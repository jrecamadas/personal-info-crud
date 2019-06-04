<?php

namespace App\Http\Controllers\Api;

use Dingo\Api\Http\Request;

interface APIInterface
{
    public function index(Request $request);

    public function show($id);

    public function destroy($id);

    public function update(Request $request, $id);

    public function store(Request $request);
}
