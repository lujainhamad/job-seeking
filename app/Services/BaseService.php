<?php

namespace App\Services;

use Exception;
use ReflectionClass;
use App\Helpers\Transaction;
use App\Exceptions\CustomExceptionWithMessage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Throwable;

class BaseService
{

    protected $model;
    public $pipeline;
    protected $storagePath = '';
    protected $relations = [];
    protected $manyToManyRelations = [];
    protected $manyToManyRelationsWithPivot = [];


    public function getAll()
    {
        $query = $this->model::query();
        $query = $this->pipeline ? $this->pipeline::make(builder: $query):$query;
        return $query;
    }

    public function getOne($model)
    {
        return $model->load($this->relations);
    }

    public function create($data)
    {
        return Transaction::run(function () use ($data) {
            foreach($data as $key => $value){
                try{
                    if(file_exists($value)){
                        $data[$key] = StorageService::storeFile($value,$this->storagePath);
                    }
                }catch(Throwable $e){}
            }
            $object = $this->model::create($data);
            if(isset($data['attachments'])){
                foreach($data['attachments'] as $attachment){
                    $path = StorageService::storeFile($attachment,$this->storagePath);
                    $object->attachments()->create([
                        'user_id' => $data['user_id'] ?? $data['user']['id'],
                        'file' => $path,
                        'type' => StorageService::getType($attachment),
                    ]);
                }
            }
            $this->handleManyToManyRelations($object, $data);
            $object->load($this->relations);

            return $object;
        });
    }

    public function update($data, $model)
    {
        return Transaction::run(function () use ($data, $model) {
                foreach($data as $key => $value){
                    try{
                        if(file_exists($value)){
                            if(isset($data[$key])){
                                StorageService::deleteFile($data[$key]);
                            }
                            $data[$key] = StorageService::storeFile($value,$this->storagePath);
                        }
                    }catch(Throwable $e){}
                }
            $model->update($data);
            if(isset($data['attachments'])){
                foreach($data['attachments'] as $attachment){
                    $path = StorageService::storeFile($attachment,$this->storagePath);
                    $model->attachments()->create([
                        'user_id' => $data['user_id'] ?? $data['user']['id'],
                        'file' => $path,
                        'type' => StorageService::getType($attachment),
                    ]);
                }
            }
            $this->handleManyToManyRelations($model, $data);
            $model->load($this->relations);

            return $model;
        });
        
    }

    public function delete($model)
    {
        return $model->delete();
    }

    public function handleManyToManyRelations($object, $data)
    {
        foreach ($this->manyToManyRelations as $relation) {
            if (isset($data[$relation]) && !empty($data[$relation])) {

                foreach ($data[$relation] as $pivot) {
                  
                    if (isset($pivot['data'])) {
                        $syncData = [$pivot['id'] => $pivot['data']];
                        $object->$relation()->sync($syncData);
                    }
                    else {
                        $object->$relation()->sync($data[$relation]);
                    }
                }
            }
        }
    }


    public function handleManyToManyRelationsWithPivotValues($object, $data, $pivotArray = [], $foreignKeys)
    {
        foreach ($this->manyToManyRelationsWithPivot as $relation) {
            if (isset($data[$relation]) && !empty($data[$relation])) {
                $syncData = [];

                foreach ($data[$relation] as $item) {
                    $compositeKey = [];
                    if (is_array($foreignKeys)) {
                        foreach ($foreignKeys as $foreignKey) {
                            if (array_key_exists($foreignKey,$item)) {
                                $compositeKey[$foreignKey] = $item[$foreignKey];
                            }
                        }
                        $key = implode('-', $compositeKey);
                    } else {
                        if (!isset($item[$foreignKeys])) {
                            throw new CustomExceptionWithMessage("Foreign key '{$foreignKeys}' not found in item.");
                        }
                        $key = $item[$foreignKeys];
                    }

                    if (!empty($pivotArray)) {
                        $pivotData = [];
                        foreach ($pivotArray as $pivot) {
                            if (array_key_exists($pivot, $item)) {
                                $pivotData[$pivot] = $item[$pivot];
                            } else {
                                throw new CustomExceptionWithMessage('Pivot element not found');
                            }
                        }
                        $syncData[$key] = $pivotData;
                    } else {
                        $syncData[] = $key;
                    }
                }
                $object->$relation()->sync($syncData);
            }
        }
    }

}
