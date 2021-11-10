<?php

namespace App\Http\Controllers;

use App\Models\ProductStockLog;
use Illuminate\Http\Request;

class ProductStockLogController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductStockLog  $productStockLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductStockLog $productStockLog)
    {
        ProductStockLog::destroy($productStockLog->id);

        return redirect()->back()->with('delete_success', 'Berhasil dihapus!');
    }
}
