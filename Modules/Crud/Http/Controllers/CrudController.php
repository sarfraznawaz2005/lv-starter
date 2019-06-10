<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/20/2017
 * Time: 12:30 PM
 */

namespace Modules\Crud\Http\Controllers;

use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Meta;
use Modules\Core\Http\Controllers\CoreController;
use Nwidart\Modules\Facades\Module;

class CrudController extends CoreController
{
    protected $nonModuleCommands = [
        'make:widget'
    ];

    public function index()
    {
        title('Module Manager');

        $migrationsPending = $this->areMigrationsPending();

        return view('crud::pages.index', compact('migrationsPending'));
    }

    /**
     * Create new module
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->runCommand('module:make', $request->get('name'));
    }

    public function publish(): \Illuminate\Http\RedirectResponse
    {
        $output = '';

        File::cleanDirectory(base_path('public/modules'));

        File::cleanDirectory(base_path('database/migrations'));
        @file_put_contents(base_path('database/migrations') . '/.gitignore', '*');

        Artisan::call('vendor:publish', ['--all' => true]);

        $output .= Artisan::output();
        Artisan::call('module:publish-config', ['--force' => true]);
        $output .= Artisan::output();
        Artisan::call('module:publish-migration');
        $output .= Artisan::output();
        Artisan::call('module:publish-translation');
        $output .= Artisan::output();

        Artisan::call('module:publish');
        $output .= Artisan::output();

        //echo $output;exit;

        $this->optimize();

        flash('Modules Published Successfully!', 'success');
        return redirect()->back();
    }

    protected function optimize(): void
    {
        $output = '';

        Artisan::call('clear-compiled');
        $output .= Artisan::output();
        Artisan::call('cache:clear');
        $output .= Artisan::output();
        Artisan::call('view:clear');
        $output .= Artisan::output();
        Artisan::call('config:clear');
        $output .= Artisan::output();
        Artisan::call('app:cleanup');
        $output .= Artisan::output();

        //echo $output;exit;
    }

    public function toggleStatus($moduleName)
    {
        if ($moduleName !== 'Core' && $moduleName !== 'Crud') {
            if (Module::has($moduleName)) {
                $module = Module::find($moduleName);

                if ($module) {
                    $status = 'Enabled';
                    $isEnabled = $module->isStatus(1);

                    if ($isEnabled) {
                        $status = 'Disabled';
                        $module->disable();
                    } else {
                        $module->enable();
                    }

                    flash("Module $status Successfully!", 'success');
                    return redirect()->back();
                }
            }
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createFile(Request $request)
    {
        $name = trim(ucwords($request->get('name')));
        $commandArgument = $name . ' ' . $request->get('module');

        return $this->runCommand($request->get('command'), $commandArgument);
    }

    public function destroy($moduleName)
    {
        if (Module::has($moduleName)) {
            if (!in_array($moduleName, Module::getSystemModules())) {
                $module = Module::find($moduleName);

                if ($module && $module->delete()) {
                    flash('Deleted Successfully!', 'success');
                    return redirect()->back();
                }
            }
        }

        return redirect()->back();
    }

    protected function returnBackWithError($error)
    {
        return redirect()->back()->withErrors([
            'error' => $error
        ]);
    }

    /**
     * @param $commandName
     * @param string $commandArgument
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function runCommand($commandName, $commandArgument = '', $message = ''): \Illuminate\Http\RedirectResponse
    {
        $moduleName = request()->get('module');
        $name = request()->get('name');

        if ($commandArgument) {
            $command = $this->getArtisan() . $commandName . ' ' . $commandArgument . ' 2>&1';
        } else {
            $command = $this->getArtisan() . $commandName . ' 2>&1';
        }

        if (in_array($commandName, $this->nonModuleCommands, true)) {
            $command = $this->getArtisan() . $commandName . ' ' . $name . ' 2>&1';
        }

        $result = shell_exec($command);

        if ($result) {
            if (in_array($commandName, $this->nonModuleCommands, true)) {
                if ($commandName === 'make:widget') {

                    if (file_exists(base_path('resources/views/widgets'))) {
                        rename(
                            base_path('resources/views/widgets'),
                            base_path('Modules/' . $moduleName . '/Resources/views/widgets')
                        );
                    }

                    if (file_exists(base_path('app/Widgets'))) {
                        if (
                        rename(
                            base_path('app/Widgets'),
                            base_path('Modules/' . $moduleName . '/Widgets')
                        )
                        ) {
                            $message = 'Widget created successfully!';
                        }
                    }

                }
            }

            flash($message ?: nl2br($result), $commandName === 'module:make' ? 'info' : 'success');

            if ($commandName === 'module:make') {
                shell_exec($this->getArtisan() . 'module:setup');
            }
        }

        return redirect()->back();
    }

    /**
     * runs only new migrations
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function migrate(): \Illuminate\Http\RedirectResponse
    {
        $output = '';

        File::cleanDirectory(base_path('database/migrations'));
        @file_put_contents(base_path('database/migrations') . '/.gitignore', '*');
        Artisan::call('module:publish-migration');
        sleep(3);

        $dir = base_path() . '/database/migrations';
        $allFiles = glob($dir . '/*.php', GLOB_NOSORT);

        if ($allFiles) {
            $migrations = DB::table('migrations')->select('migration')->get()->pluck('migration')->toArray();

            if ($migrations) {
                foreach ($allFiles as $file) {
                    $fileName = pathinfo(basename($file))['filename'];

                    if (false !== in_array($fileName, $migrations, true)) {
                        @unlink($file);
                    }
                }
            }
        }

        Artisan::call('migrate', ['--force' => true]);
        $output .= Artisan::output();

        flash($output ? nl2br($output) : 'Nothing to migrate.', 'warning');

        return redirect()->back();
    }

    protected function getArtisan(): string
    {
        $php = 'php';
        $result = shell_exec("$php -v 2>&1");
        $isPHP = stripos($result, 'php') !== false;

        if (!$isPHP) {
            $php = 'php-cli';
            $result = shell_exec("$php -v 2>&1");
            $isPHP = stripos($result, 'php') !== false;
        }

        if (!$isPHP) {
            $php = PHP_BINARY;
            $result = shell_exec("$php -v 2>&1");
            $isPHP = stripos($result, 'php') !== false;
        }

        if (!$isPHP) {
            $php = PHP_BINARY . '-cli';
            $result = shell_exec("$php -v 2>&1");
            $isPHP = stripos($result, 'php') !== false;
        }

        if (!$isPHP) {
            throw new \RuntimeException('Error: Could not find PHP binary.');
        }

        return $php . ' ' . base_path() . '/artisan ';
    }

    protected function areMigrationsPending(): bool
    {
        $output = '';

        Artisan::call('migrate', ['--pretend' => true]);
        $output .= Artisan::output();

        if (false === strpos($output, 'Nothing')) {
            return true;
        }

        return false;
    }
}
