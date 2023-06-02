    /**
     * Display a listing of the {{ $config->modelNames->name }}.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|void
     */
    public function index(Request $request) {
        return view('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.index');
    }
