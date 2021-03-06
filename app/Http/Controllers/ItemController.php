<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/* Extending the Controller class. */

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Get the top six items from the database, ordered by name, and return them.
     *
     * @return An array of items
     */
    public function getAll()
    {
        $items = Item::orderBy('name', 'desc')->select('name')->get();
        return $items;
    }

    public function getItemDetail(Request $request)
    {
        $item = Item::find($request->id);

        return view('components.per-product', compact('item'));
    }



    /**
     * It gets the items list from the database, and then returns the view
     *
     * @param Request request the request object
     *
     * @return a view of the product list.
     */
    public function getItemsList(Request $request)
    {
        $items = DB::table('items')
            ->select(DB::raw('COUNT(invoice_items.id) as terbeli, items.id, items.retail_price, items.category, items.name, items.stock'))
            ->join('invoice_items', 'invoice_items.item_id', '=', 'items.id')
            ->groupBy('item_id')
            ->groupBy('items.retail_price', 'items.category', 'items.name', 'items.stock', 'items.id')
            ->paginate(10);
        return view('components.product-list', compact('items'));
    }

    /**
     * It gets the items from the database and returns a view with the items
     *
     * @param Request request The request object.
     *
     * @return a view of the product-grid.blade.php file.
     */
    public function getItemsGrid(Request $request)
    {
        $items = DB::table('invoice_items')
            // ->select(DB::raw('item_id, items.retail_price, items.name, (CAST(items.stock as float)/CAST(items.max_stock as float))*100 as remaining_stock'))
            // ->join('items', 'invoice_items.item_id', '=', 'items.id')
            // ->groupBy('item_id')
            // ->groupBy('items.retail_price')
            // ->groupBy('items.name')
            // // ->groupBy('items.category')
            // ->groupBy('remaining_stock')
            // ->paginate(20);
            ->select(DB::raw('COUNT(invoice_items.id) as terbeli, item_id, items.retail_price, items.category, items.name, items.stock, (CAST(items.stock as float)/CAST(items.max_stock as float))*100 as remaining_stock'))
            ->join('items', 'invoice_items.item_id', '=', 'items.id')
            ->groupBy('item_id', 'items.retail_price', 'items.category', 'items.name', 'items.stock', 'items.max_stock')
            ->paginate(20);
        return view('components.product-grid', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }

    /**
     * It gets the data from the database and returns it to the view
     *
     * @return The data is being returned in the form of a view.
     */
    public function getData()
    {
        $invoices = DB::table('invoices')
            ->select(DB::raw('SUM(items.retail_price) as total_price, COUNT(items.retail_price) as total_items, invoices.id, invoices.invoice_date, users.username, users.email'))
            ->join('users', 'invoices.user_id', '=', 'users.id')
            ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->join('items', 'invoice_items.item_id', '=', 'items.id')
            ->whereYear('invoices.invoice_date', '=', date('Y') - 1)
            ->groupBy('invoices.id')
            ->groupBy('invoices.invoice_date')
            ->groupBy('users.username')
            ->groupBy('users.email')
            ->paginate(10);

        $invoice_select = 'year';
        $total_invoices = DB::table('invoices')->whereYear('invoice_date', '=', date('Y') - 1)->count();

        return view('components.table-penjualan', compact('invoices', 'total_invoices', 'invoice_select'));
    }
    /**
     * It searches for items in the database and returns a view with the results
     *
     * @param Request request The request object.
     *
     * @return The view is being returned.
     */
    public function itemSearch(Request $request)
    {
        $name = $request->search;
        $items = Item::where('name', 'like', '%' . $name . '%')->limit(4)->get();
        // response()->json($items);
        // return response()->json($items);
        return view('components.edit-stock-modal', compact('items'));
    }

    /**
     * It updates the stock of an item in the database
     *
     * @param Request request The request object.
     */
    public function updateStock(Request $request)
    {
        DB::table('items')
            ->where('id', $request->id)
            ->update(array('stock' => $request->stock));
    }

    /**
     * It returns the stock of the product.
     */
    public function getStock()
    {
    }

    /**
     * > This function creates a pie chart
     */
    public function pieChart()
    {
    }
}
