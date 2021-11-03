<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AppRepository
{
    /**
     * Eloquent model instance.
     */
    protected $model;
    /**
     * load default class dependencies.
     * 
     * @param Model $model Illuminate\Database\Eloquent\Model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    /**
     * get collection of items in paginate format.
     * 
     * @return Collection of items.
     */
    public function paginate(Request $request)
    {
        return $this->model->paginate($request->input('limit', 10));
    }
    /**
     * create new record in database.
     * 
     * @param Request $request Illuminate\Http\Request
     * @return saved model object with data.
     */
    public function store($data)
    {
        $item = $this->model;
        $item->fill($data);
        $item->save();
         return $item;
    }

    /**
     * Delete item by primary key id.
     * 
     * @param  Integer $id integer of primary key id.
     * @return boolean
     */
    public function deleteAll($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();;
    }
}
