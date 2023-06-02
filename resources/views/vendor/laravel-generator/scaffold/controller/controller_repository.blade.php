@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{ $config->namespaces->controller }};

@if(config('laravel_generator.tables') === 'datatables')
use {{ $config->namespaces->dataTables }}\{{ $config->modelNames->name }}DataTable;
@endif
use {{ $config->namespaces->request }}\{{ $config->modelNames->name }}\CreateRequest;
use {{ $config->namespaces->request }}\{{ $config->modelNames->name }}\UpdateRequest;
use {{ $config->namespaces->app }}\Http\Controllers\AppBaseController;
use {{ $config->namespaces->repository }}\{{ $config->modelNames->name }}Repository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use App\MyClasses\GeneralHelperFunctions;
use {{ $config->namespaces->model }}\{{ $config->modelNames->name }};
use Illuminate\Support\Facades\DB;
use Response;

class {{ $config->modelNames->name }}Controller extends AppBaseController
{
    /** @var {{ $config->modelNames->name }}Repository ${{ $config->modelNames->camel }}Repository*/
    private ${{ $config->modelNames->camel }}Repository;

    public function __construct({{ $config->modelNames->name }}Repository ${{ $config->modelNames->camel }}Repo)
    {
        $this->{{ $config->modelNames->camel }}Repository = ${{ $config->modelNames->camel }}Repo;
    }

    {!! $indexMethod !!}

    /**
     * Show the form for creating a new {{ $config->modelNames->name }}.
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|void
     */
    public function create() {
        return view('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.create');
    }

    /**
     * Store a newly created {{ $config->modelNames->name }} in storage.
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CreateRequest $request) {
        DB::beginTransaction();
        ${{ $config->modelNames->camel }} = {{ $config->modelNames->name }}::create($request->validated());
        DB::commit();

        return Response::json(['message' => '{{ $config->modelNames->name }} has been created successfully.'
            . GeneralHelperFunctions::getSuccessResponseBtn(${{ $config->modelNames->camel }}, route('{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.edit', ${{ $config->modelNames->camel }}))]);
    }

    /**
     * Display the specified {{ $config->modelNames->name }}.
     *
     * @param {{ $config->modelNames->name }} ${{ $config->modelNames->camel }}
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|void
     */
    public function show({{ $config->modelNames->name }} ${{ $config->modelNames->camel }}) {
        return view('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.show')->with('{{ $config->modelNames->camel }}', ${{ $config->modelNames->camel }});
    }

    /**
     * Show the form for editing the specified {{ $config->modelNames->name }}.
     *
     * @param {{ $config->modelNames->name }} ${{ $config->modelNames->camel }}
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|void
     */
    public function edit({{ $config->modelNames->name }} ${{ $config->modelNames->camel }}) {
        return view('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.edit')->with('{{ $config->modelNames->camel }}', ${{ $config->modelNames->camel }});
    }

    /**
     * Update the specified {{ $config->modelNames->name }} in storage.
     *
     * @param {{ $config->modelNames->name }} ${{ $config->modelNames->camel }}
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update({{ $config->modelNames->name }} ${{ $config->modelNames->camel }}, UpdateRequest $request) {
        DB::beginTransaction();
        ${{ $config->modelNames->camel }}->update($request->validated());
        DB::commit();

        return Response::json(['message' => '{{ $config->modelNames->name }} updated successfully.']);
    }

    /**
     * Remove the specified {{ $config->modelNames->name }} from storage.
     *
     * @param {{ $config->modelNames->name }} ${{ $config->modelNames->camel }}
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy({{ $config->modelNames->name }} ${{ $config->modelNames->camel }}) {
        ${{ $config->modelNames->camel }}->delete();

        return Response::json(['message' => '{{ $config->modelNames->name }} deleted successfully']);
    }
}
