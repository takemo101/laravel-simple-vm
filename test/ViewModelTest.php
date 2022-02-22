<?php

namespace Test;

use Illuminate\Support\Collection;
use Takemo101\LaravelSimpleVM\{
    ViewModel,
    ViewModelConfig,
};
use Takemo101\SimpleVM\Attribute\{
    Ignore,
    ChangeName,
};

class ViewModelTest extends TestCase
{
    /**
     * @test
     */
    public function createViewModel__OK(): void
    {
        $model = TestViewModel::of(
            [1, 2, 3],
            'B',
        );

        $data = $model->toArray();

        $this->assertTrue(count($data['a']) == 3);
        $this->assertFalse(array_key_exists('b', $data));
        $this->assertTrue(array_key_exists('cc', $data));
        $this->assertTrue(is_array($data['cc']['ccc']));
    }

    /**
     * @test
     */
    public function executeToJson__OK(): void
    {
        $model = JsonViewModel::of(
            'A',
        );

        $json = $model->toJson();

        $this->assertEquals($json, '{"a":"A","CC":"C"}');
    }
}

/**
 * test view model class
 */
class TestViewModel extends ViewModel
{
    public function __construct(
        public array $a,
        #[Ignore]
        public string $b,
    ) {
        //
    }

    #[ChangeName('cc')]
    public function c(ViewModelConfig $config): Collection
    {
        return new Collection([
            'ccc' => [
                1,
                2,
                $config->getPath(),
            ],
        ]);
    }
}


/**
 * test json view model class
 */
class JsonViewModel extends ViewModel
{
    public function __construct(
        public string $a,
    ) {
        //
    }

    #[ChangeName('CC')]
    public function c(): string
    {
        return 'C';
    }
}
