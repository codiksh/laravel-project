    /**
     * Display a listing of the {{ $config->modelNames->name }}.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|void
     */
    public function index(Request $request) {
        ${{ $config->modelNames->camelPlural }} = $this->{{ $config->modelNames->camel }}Repository->{!! $renderType !!};

        return view('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.index')
            ->with('{{ $config->modelNames->camelPlural }}', ${{ $config->modelNames->camelPlural }});
    }
