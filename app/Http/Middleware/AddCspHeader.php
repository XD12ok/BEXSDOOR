<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddCspHeader
{
public function handle(Request $request, Closure $next)
{
$response = $next($request);

$response->headers->set(
'Content-Security-Policy',
"script-src 'self' https://app.sandbox.midtrans.com 'unsafe-inline' 'unsafe-eval'"
);

return $response;
}
}
