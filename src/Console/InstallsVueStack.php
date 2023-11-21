<?php

namespace Laravel\Breeze\Console;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

trait InstallsVueStack
{
    /**
     * Install the Blade Bootstrap Breeze stack.
     *
     * @return int|null
     */
    protected function installBootstrapStack()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                "@popperjs/core" => "^2.11.6",
                "@vitejs/plugin-vue" => "^4.3.4",
                "axios"=> "^1.1.2",
                "bootstrap"=> "^5.2.3",
                "laravel-vite-plugin"=> "^0.8.0",
                "lodash"=> "^4.17.19",
                "postcss"=> "^8.1.14",
                "sass"=> "^1.56.1",
                "vite"=> "^4.4.9",
                "vue"=> "^3.2.37"
            ] + $packages;
        });

        // Controllers...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/vue/app/Http/Controllers', app_path('Http/Controllers'));

        // Requests...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/vue/app/Http/Requests', app_path('Http/Requests'));

        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/vue/resources/views', resource_path('views'));

        if (! $this->option('dark')) {
            $this->removeDarkClasses((new Finder)
                ->in(resource_path('views'))
                ->name('*.blade.php')
                ->notName('welcome.blade.php')
            );
        }

        // Components...
        (new Filesystem)->ensureDirectoryExists(app_path('View/Components'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/vue/app/View/Components', app_path('View/Components'));

        // Tests...
        if (! $this->installTests()) {
            return 1;
        }

        // Routes...
        copy(__DIR__.'/../../stubs/vue/routes/web.php', base_path('routes/web.php'));
        copy(__DIR__.'/../../stubs/vue/routes/auth.php', base_path('routes/auth.php'));

        // "Dashboard" Route...
        $this->replaceInFile('/home', '/dashboard', resource_path('views/welcome.blade.php'));
        $this->replaceInFile('Home', 'Dashboard', resource_path('views/welcome.blade.php'));
        $this->replaceInFile('/home', '/dashboard', app_path('Providers/RouteServiceProvider.php'));

        // Tailwind / bootstrap / Vite...
        
        //copy(__DIR__.'/../../stubs/vue/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__.'/../../stubs/vue/postcss.config.js', base_path('postcss.config.js'));
        copy(__DIR__.'/../../stubs/vue/vite.config.js', base_path('vite.config.js'));
        copy(__DIR__.'/../../stubs/vue/resources/scss/app.css', resource_path('scss/app.scss'));
        copy(__DIR__.'/../../stubs/vue/resources/js/app.js', resource_path('js/app.js'));

        $this->components->info('Installing and building Node dependencies.');

        if (file_exists(base_path('pnpm-lock.yaml'))) {
            $this->runCommands(['pnpm install', 'pnpm run build']);
        } elseif (file_exists(base_path('yarn.lock'))) {
            $this->runCommands(['yarn install', 'yarn run build']);
        } else {
            $this->runCommands(['npm install', 'npm run build']);
        }

        $this->line('');
        $this->components->info('Breeze Vue-bootstrap scaffolding installed successfully.');
    }
}
