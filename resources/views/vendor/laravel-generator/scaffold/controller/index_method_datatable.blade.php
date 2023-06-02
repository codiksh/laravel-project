    /**
     * Display a listing of the {{ $config->modelNames->name }}.
     *
     * @param {{ $config->modelNames->name }}DataTable ${{ $config->modelNames->camel }}DataTable
     * @return Response
     */
    public function index({{ $config->modelNames->name }}DataTable ${{ $config->modelNames->camel }}DataTable) {
        return ${{ $config->modelNames->camel }}DataTable->render('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.index');
    }
