<?php

namespace GarbuzIvan\LogViewer;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LogController extends Controller
{
    public function index($file = null, Request $request)
    {
        if ($file === null) {
            $file = (new LogViewer())->getLastModifiedLog();
        }

        return Admin::content(function(Content $content) use ($file, $request) {
            $offset = $request->get('offset');

            $viewer = new LogViewer($file);

            $content->body(view('laravel-admin-logs::logs', [
                'logs' => $viewer->fetch($offset),
                'logFiles' => $viewer->getLogFiles(),
                'fileName' => $viewer->file,
                'end' => $viewer->getFilesize(),
                'tailPath' => route('log-viewer-tail', ['file' => $viewer->file]),
                'trashPath' => mb_strlen($viewer->file) > 0 ? route('log-viewer-trash', ['file' => $viewer->file]) : '',
                'prevUrl' => $viewer->getPrevPageUrl(),
                'nextUrl' => $viewer->getNextPageUrl(),
                'filePath' => $viewer->getFilePath(),
                'size' => static::bytesToHuman($viewer->getFilesize()),
            ]));

            $content->header($viewer->getFilePath());
        });
    }

    /**
     * @param $file
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function trash($file, Request $request): \Illuminate\Http\RedirectResponse
    {
        $viewer = new LogViewer($file);
        if(file_exists($viewer->getFilePath())){
            unlink($viewer->getFilePath());
        }
        return redirect()->back();
    }

    public function tail($file, Request $request)
    {
        $offset = $request->get('offset');

        $viewer = new LogViewer($file);

        list($pos, $logs) = $viewer->tail($offset);

        return compact('pos', 'logs');
    }

    protected static function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
