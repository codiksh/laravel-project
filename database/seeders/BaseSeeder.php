<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

class BaseSeeder extends \Illuminate\Database\Seeder {

    /**
     * Name of variable that contains the array to be seeded
     * @var string
     */
    protected $arrVarName = 'list';

    /**
     * Name of column to be used for existing-verification
     * @var string
     */
    protected $existingVerificationCol = 'name';

    /**
     * Name of existing verification column from array, if different than in db, else null.
     * @var null
     */
    protected $existingVerificationCol_inArr = null;

    /**
     * Instance of model.
     * @var null | \Illuminate\Database\Eloquent\Model
     */
    protected $model = null;

    /**
     * Name of entity being seeded, used for consoling and logging.
     * @var string
     */
    protected $entityName = 'Entity';

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        DB::beginTransaction();
        $totalSeeded = 0;
        foreach ($this->{$this->arrVarName} as $item) {
            if(! $this->model::where($this->existingVerificationCol,$item[$this->getExistingVerificationCol_inArr()])->exists()){
                $record = $this->model::create($item);
                $this->command->info( $this->entityName . ': ' . $record->{$this->existingVerificationCol} . ' seeded successfully.');
                $totalSeeded++;
            }else{
                if($this->command->confirm($this->entityName.': "' . $item['name'] . '" is already registered in the database, do you want to overwrite the value with seeder\'s?',0)) {
                    $record = $this->model::where('name', $item['name'])->firstOrFail();
                    $record->update(['is_nd' => $item['is_nd']]);
                    $this->command->info( $this->entityName . ': ' . $record->{$this->existingVerificationCol} . ' seeded successfully.');
                    $totalSeeded++;
                }
            }
        }
        $this->command->info('Total ' . \Illuminate\Support\Str::plural($this->entityName) . ' seeded: ' . $totalSeeded);
        DB::commit();
    }

    /**
     * Returns existing verification col name from array
     * @return string|null
     */
    protected function getExistingVerificationCol_inArr() {
        return $this->existingVerificationCol_inArr ?? $this->existingVerificationCol;
    }
}
