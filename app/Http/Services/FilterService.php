<?php

namespace App\Http\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilterService
{
    /**
     * @var array
     */
    protected $filterables = [
        "App\Models\Page" => [
            "order_by" => [
                ["protection", "desc"],
                ["created_at", "desc"],
            ],
            "search_in" => "title,description",
        ],
    ];

    /**
     * @var null|array
     */
    protected $filterable;

    /**
     * @var Model
     */
    public $model;

    /**
     * @var int
     */
    public $limit;

    /**
     *
     * @var bool
     */
    public $filtering;

    /**
     * @param Model $model model instance
     * @param int $limit
     */
    public function __construct($model, int $limit = 20)
    {
        $this->model = $model;
        $this->limit = $limit;
        $this->filtering = false;

        $this->filterable = $this->filterables[get_class($this->model)] ?? null;
    }

    /**
     * @param Request $request
     * @return FilterService
     */
    public function filter(Request $request)
    {
        $filters = Validator::validate(
            $request->only(["filter", "search"]),
            [
                "filter" => ["nullable", "boolean"],
                "search" => ["nullable", "string"],
            ]
        );

        $this->model = $this->model->whereNotNull("id");

        if ($filterable = $this->filterable) {
            if ($orders = $filterable["order_by"]) {
                foreach ($orders as $order) {
                    $this->model = $this->model->orderBy($$order[0], $$order[1]);
                }
            }

            if ($filters["filter"] ?? null) {
                if ($filters["search"] ?? null) {
                    $this->model = $this->model->whereRaw("MATCH(" . $filterable["search_in"] . ") AGAINST('{$filters['search']}')");
                }

                $this->filtering = true;
            }
        }

        $this->model = $this->model->paginate($this->limit);

        return $this;
    }
}
