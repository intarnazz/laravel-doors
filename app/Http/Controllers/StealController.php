<?php

namespace App\Http\Controllers;


use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\Door;
use App\Models\Image;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse; // Импортируем JsonResponse

class StealController extends Controller
{
    function get()
    {
        $url = 'http://xn---33-5cdanekkarms5au6c.xn--p1ai/catalog/mezhkomnatnye_dveri/triadoors/l1-po-8334#v676108';
        $client = new Client();
        $response = $client->get($url);
        return $response->getBody()->getContents();
    }

    public function obj(): JsonResponse
    {
        $url = 'http://xn---33-5cdanekkarms5au6c.xn--p1ai/catalog/mezhkomnatnye_dveri/triadoors/l1-po-8334#v676108';

        // Создаем клиента и делаем запрос
        $client = new Client();
        try {
            $response = $client->get($url);
            $htmlContent = $response->getBody()->getContents();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка при получении данных: ' . $e->getMessage()], 500);
        }

        // Парсим HTML
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($htmlContent);
        libxml_clear_errors();

        // Инициализация DOMXPath для поиска элементов по классам
        $xpath = new \DOMXPath($dom);

        // Ищем первый тег <h1>
        $h1Tags = $dom->getElementsByTagName('h1');
        $h1Text = $h1Tags->length > 0 ? $h1Tags->item(0)->nodeValue : 'Тег H1 не найден';

        // Очищаем поле name, извлекая только основную часть
        $name = $h1Text;
        $group = null;
        if (strpos($name, 'Межкомнатная дверь ') !== false) {
            // Удаляем 'Межкомнатная дверь ' из строки, чтобы получить группу
            $group = trim(str_replace('Межкомнатная дверь ', '', $name));
        }

        // Ищем элемент с классом 'card-price_value'
        $priceNodes = $xpath->query("//*[contains(@class, 'card-price_value')]");
        $cleanPrice = null;
        if ($priceNodes->length > 0) {
            $rawPrice = $priceNodes->item(0)->nodeValue;
            $cleanPrice = trim(preg_replace('/[^\d]/', '', $rawPrice));
        }

        // Ищем элементы с классом 'card-group_title'
        $colorNodes = $xpath->query("//*[contains(@class, 'card-group_title')]");
        $colorName = null;
        $colorPath = null;
        if ($colorNodes->length > 2) {
            $colorSpan = $colorNodes->item(2)->getElementsByTagName('span');
            $colorName = $colorSpan->length > 0 ? trim($colorSpan->item(0)->nodeValue) : 'Цвет не найден';

            // Ищем тег <img> по атрибуту data-value равному содержимому цвета
            $imgNodes = $xpath->query("//img[@data-value='$colorName']");
            if ($imgNodes->length > 0) {
                $colorPath = $imgNodes->item(0)->getAttribute('src');
            }
        }

        // Извлекаем id из URL
        preg_match('/v(\d+)/', $url, $matches);
        $id = isset($matches[1]) ? $matches[1] : null;

        $brand = null;
        $material = null;

        // Если id найден, выполняем второй запрос
        if ($id) {
            $attributesUrl = "https://xn---33-5cdanekkarms5au6c.xn--p1ai/catalog/attributes?variant_id=$id";
            try {
                $attributesResponse = $client->get($attributesUrl);
                $attributesData = json_decode($attributesResponse->getBody()->getContents(), true);

                // Извлекаем бренд и материал из ответа
                foreach ($attributesData as $attribute) {
                    if ($attribute['name'] === 'Бренд') {
                        $brand = $attribute['value'];
                    } elseif ($attribute['name'] === 'Материал') {
                        $material = $attribute['value'];
                    }
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'Ошибка при получении атрибутов: ' . $e->getMessage()], 500);
            }
        }

        // Возвращаем JSON-ответ
        return response()->json([
            'name' => $name,
            'group' => $group,
            'price' => $cleanPrice ? (int) $cleanPrice : 'Цена не найдена',
            'brand' => $brand ? $brand : 'Бренд не найден',
            'material' => $material ? $material : 'Материал не найден',
            'color' => [
                'name' => $colorName,
                'path' => $colorPath ? $colorPath : 'Путь к изображению не найден'
            ]
        ]);
    }
}
