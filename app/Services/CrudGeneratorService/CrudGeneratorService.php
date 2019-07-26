<?php

namespace App\Services\CrudGeneratorService;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CrudGeneratorService
{

    protected static function GetStubs($type)
    {
        return file_get_contents(resource_path("/stubs/$type.stub"));
    }


    /**
     * @param $name
     * This will create controller from stub file
     */
    public static function MakeController($name)
    {
        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower($name)
            ],

            CrudGeneratorService::GetStubs('Controller')
        );
        if (!file_exists($path = app_path("/Http/Controllers/{$name}")))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Controllers/{$name}/{$name}Controller.php"), $template);
    }

    /**
     * @param $name
     * This will create model from stub file
     */
    public static function MakeModel($name)
    {
        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower($name)
            ],
            CrudGeneratorService::GetStubs('Model')
        );
        if (!file_exists($path = app_path('/Models')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Models/{$name}.php"), $template);
    }

    /**
     * @param $name
     * This will create Request from stub file
     */
    public static function MakeRequest($name)
    {
        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower($name)
            ],
            CrudGeneratorService::GetStubs('Request')
        );

        if (!file_exists($path = app_path('/Http/Requests/')))
            mkdir($path, 0777, true);
        if (!file_exists($path = app_path("/Http/Requests/{$name}")))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Requests/{$name}/{$name}Request.php"), $template);
    }

    /**
     * @param $name
     * This will create migration using artisan command
     */
    public static function MakeMigration($name)
    {
        Artisan::call('make:migration create_' . strtolower(Str::plural($name)) . '_table --create=' . strtolower(Str::plural($name)));
    }

    /**
     * @param $name
     * This will create route in api.php file
     */
    public static function MakeRoute($name)
    {
        $path_to_file  = base_path('routes/api.php');
        $append_route =
            '$api->group([\'prefix\' => \'' . Str::plural(strtolower($name)) . '\', \'namespace\' => \'' . $name . '\'], function ($api) {' . "\n"
            . "\t" . '$api->get(\'/\',\'' . $name . 'Controller@index\');' . "\n"
            . "\t" . '$api->get(\'/{id}\',\'' . $name . 'Controller@show\');' . "\n"
            . "\t" . '$api->post(\'/\',\'' . $name . 'Controller@store\');' . "\n"
            . "\t" . '$api->put(\'/{id}\',\'' . $name . 'Controller@update\');' . "\n"
            . "\t" . '$api->delete(\'/{id}\',\'' . $name . 'Controller@destroy\');' . "\n" .
            '});' . "\n";

        File::append($path_to_file, $append_route);
    }


    public static function MakeProcessor($name)
    {
        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower($name)
            ],
            CrudGeneratorService::GetStubs('Processor')
        );
        if (!file_exists($path = app_path('/Processors')))
            mkdir($path, 0777, true);
        if (!file_exists($path = app_path("/Processors/{$name}")))
            mkdir($path, 0777, true);
        file_put_contents(app_path("/Processors/{$name}/{$name}.php"), $template);
    }

    public static function MakeTransformer($name)
    {
        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower($name)
            ],
            CrudGeneratorService::GetStubs('Transformer')
        );
        if (!file_exists($path = app_path('/Http/Transformer')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Transformer/{$name}Transformer.php"), $template);
    }
}
