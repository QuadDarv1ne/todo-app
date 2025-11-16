<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class ClientLogController extends Controller
{
    public function logJsError(Request $request)
    {
        Log::channel('client')->error('JS Error', [
            'message' => $request->input('message'),
            'source' => $request->input('source'),
            'lineno' => $request->input('lineno'),
            'colno' => $request->input('colno'),
            'stack' => $request->input('stack'),
            'userAgent' => $request->input('userAgent'),
            'url' => $request->input('url'),
        ]);
        return response()->json(['status' => 'ok']);
    }

    public function logPerformance(Request $request)
    {
        Log::channel('client')->info('Performance', [
            'loadTime' => $request->input('loadTime'),
            'userAgent' => $request->input('userAgent'),
            'url' => $request->input('url'),
        ]);
        return response()->json(['status' => 'ok']);
    }
}
