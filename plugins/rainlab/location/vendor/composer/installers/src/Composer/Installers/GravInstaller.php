<?php
namespace Composer\Installers;

class GravInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin' => 'user1/plugins/{$name}/',
        'theme'  => 'user1/themes/{$name}/',
    );

    /**
     * Format package name
     *
     * @param array $vars
     *
     * @return array
     */
    public function inflectPackageVars($vars)
    {
        $restrictedWords = implode('|', array_keys($this->locations));

        $vars['name'] = strtolower($vars['name']);
        $vars['name'] = preg_replace('/^(?:grav-)?(?:(?:'.$restrictedWords.')-)?(.*?)(?:-(?:'.$restrictedWords.'))?$/ui',
            '$1',
            $vars['name']
        );

        return $vars;
    }
}
