<?php

namespace App\Http\Domains\Project\Repository;

use App\Http\Domains\EAV\Model\Attribute;
use App\Http\Domains\EAV\Model\AttributeValue;
use App\Http\Domains\Project\Contract\ProjectInterface;
use App\Http\Domains\Project\Model\Project;
use App\Http\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProjectRepository extends BaseRepository implements ProjectInterface
{
    protected function model(): string
    {
        return Project::class;
    }

    /**
     * @throws \Exception
     */
    public function create(array $data): Model
    {
        DB::beginTransaction();
        try {
            $model = parent::create($data);
            if (isset($data['user_ids'])) {
                $model->users()->attach($data['user_ids']);
            }
            if (!isset($data['attributes'])) {
                DB::commit();
                return $model;
            }
            foreach ($data['attributes'] as $attributeName => $attributeValue) {
                $attribute = Attribute::where('name', $attributeName)->first();

                if ($attribute) {
                    AttributeValue::create([
                        'attribute_id' => $attribute->id,
                        'entity_id' => $model->id,
                        'entity_type' => Project::class,
                        'value' => $attributeValue,
                    ]);
                }
            }
            DB::commit();
            return $model;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @throws \Exception
     */
    public function update(Model $model, array $data): Model
    {
        DB::beginTransaction();
        try {
            $model = parent::update($model, $data);
            if (isset($data['user_ids'])) {
                $model->users()->sync($data['user_ids']);
            }
            if (!isset($data['attributes'])) {
                DB::commit();
                return $model;
            }
            foreach ($data['attributes'] as $attributeName => $attributeValue) {
                $attribute = Attribute::where('name', $attributeName)->first();
                if (!$attribute) {
                    throw new ModelNotFoundException('Invalid attribute');
                }

                $attributeValueModel = AttributeValue::where([
                    'attribute_id' => $attribute->id,
                    'entity_id' => $model->id,
                    'entity_type' => Project::class,
                ])->first();

                if ($attributeValueModel) {
                    $attributeValueModel->value = $attributeValue;
                    $attributeValueModel->save();
                } else {
                    AttributeValue::create([
                        'attribute_id' => $attribute->id,
                        'entity_id' => $model->id,
                        'entity_type' => Project::class,
                        'value' => $attributeValue,
                    ]);
                }
            }
            DB::commit();
            return $model;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function list(Builder $builder): LengthAwarePaginator
    {
        return parent::list($builder->with(['users', 'attributeValues.attribute']));
    }

    public function load(Project $project, array|string $relations): Project
    {
        return $project->load($relations);
    }
}
