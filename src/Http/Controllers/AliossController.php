<?php


namespace Hanson\LaravelAdminAlioss\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AliossController extends Controller
{
    public function upload()
    {
        $file = request()->file();

        if (!$file) {
            return ['error' => '没有需要上传的图片'];
        }

        $file = array_values($file)[0][0];

        $disk = request('disk', 'oss');

        try {
            $path = Storage::disk($disk)->put(request('path', ''), $file);
        } catch (\Exception $exception) {
            return ['error' => '网络错误，错误信息：'.$exception->getMessage()];
        }

        if (config('filesystems.disks.'.$disk.'.isCName')) {
            $domain = config('filesystems.disks.'.$disk.'.cdnDomain');
        } else {
            $domain = config('filesystems.disks.'.$disk.'.endpoint');
        }

        $domain = Str::endsWith($domain, '/') ? $domain : $domain . '/';

        return [
            'initialPreview' => [
                "$domain$path"
            ],
            'initialPreviewConfig' => [
                ['caption' => $file->getClientOriginalName(), 'size' => $file->getSize(), 'width' => '120px', 'url' => "/admin/alioss/delete", 'key' => $path],
            ],
            'append' => true // 是否把这些配置加入`initialPreview`。
        ];
    }

    public function delete()
    {
        return ['has_delete' => Storage::disk(request('disk'))->delete(request('key'))];
    }
}
