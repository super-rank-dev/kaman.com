<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit45cb8eb27466eeeb46b871d499268c4e
{
    public static $files = array (
        '41c664bd04a95c2d6a2f2a3e00f06593' => __DIR__ . '/..' . '/publishpress/wordpress-reviews/ReviewsController.php',
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Ctype\\' => 23,
        ),
        'P' => 
        array (
            'PublishPress\\Checklists\\Yoastseo\\' => 33,
            'PublishPress\\Checklists\\Permalinks\\' => 35,
            'PublishPress\\Checklists\\Core\\' => 29,
            'Psr\\Container\\' => 14,
            'PPVersionNotices\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'PublishPress\\Checklists\\Yoastseo\\' => 
        array (
            0 => __DIR__ . '/../..' . '/modules/yoastseo/lib',
        ),
        'PublishPress\\Checklists\\Permalinks\\' => 
        array (
            0 => __DIR__ . '/../..' . '/modules/permalinks/lib',
        ),
        'PublishPress\\Checklists\\Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'PPVersionNotices\\' => 
        array (
            0 => __DIR__ . '/..' . '/publishpress/wordpress-version-notices/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Pimple' => 
            array (
                0 => __DIR__ . '/..' . '/pimple/pimple/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'PPVersionNotices\\Module\\AdInterface' => __DIR__ . '/..' . '/publishpress/wordpress-version-notices/src/Module/AdInterface.php',
        'PPVersionNotices\\Module\\Footer\\Module' => __DIR__ . '/..' . '/publishpress/wordpress-version-notices/src/Module/Footer/Module.php',
        'PPVersionNotices\\Module\\MenuLink\\Module' => __DIR__ . '/..' . '/publishpress/wordpress-version-notices/src/Module/MenuLink/Module.php',
        'PPVersionNotices\\Module\\TopNotice\\Module' => __DIR__ . '/..' . '/publishpress/wordpress-version-notices/src/Module/TopNotice/Module.php',
        'PPVersionNotices\\ServicesProvider' => __DIR__ . '/..' . '/publishpress/wordpress-version-notices/src/ServicesProvider.php',
        'PPVersionNotices\\Template\\TemplateInvalidArgumentsException' => __DIR__ . '/..' . '/publishpress/wordpress-version-notices/src/Template/TemplateInvalidArgumentsException.php',
        'PPVersionNotices\\Template\\TemplateLoader' => __DIR__ . '/..' . '/publishpress/wordpress-version-notices/src/Template/TemplateLoader.php',
        'PPVersionNotices\\Template\\TemplateLoaderInterface' => __DIR__ . '/..' . '/publishpress/wordpress-version-notices/src/Template/TemplateLoaderInterface.php',
        'PPVersionNotices\\Template\\TemplateNotFoundException' => __DIR__ . '/..' . '/publishpress/wordpress-version-notices/src/Template/TemplateNotFoundException.php',
        'Pimple\\Container' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Container.php',
        'Pimple\\Exception\\ExpectedInvokableException' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Exception/ExpectedInvokableException.php',
        'Pimple\\Exception\\FrozenServiceException' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Exception/FrozenServiceException.php',
        'Pimple\\Exception\\InvalidServiceIdentifierException' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Exception/InvalidServiceIdentifierException.php',
        'Pimple\\Exception\\UnknownIdentifierException' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Exception/UnknownIdentifierException.php',
        'Pimple\\Psr11\\Container' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Psr11/Container.php',
        'Pimple\\Psr11\\ServiceLocator' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Psr11/ServiceLocator.php',
        'Pimple\\ServiceIterator' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/ServiceIterator.php',
        'Pimple\\ServiceProviderInterface' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/ServiceProviderInterface.php',
        'Pimple\\Tests\\Fixtures\\Invokable' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/Fixtures/Invokable.php',
        'Pimple\\Tests\\Fixtures\\NonInvokable' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/Fixtures/NonInvokable.php',
        'Pimple\\Tests\\Fixtures\\PimpleServiceProvider' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/Fixtures/PimpleServiceProvider.php',
        'Pimple\\Tests\\Fixtures\\Service' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/Fixtures/Service.php',
        'Pimple\\Tests\\PimpleServiceProviderInterfaceTest' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/PimpleServiceProviderInterfaceTest.php',
        'Pimple\\Tests\\PimpleTest' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/PimpleTest.php',
        'Pimple\\Tests\\Psr11\\ContainerTest' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/Psr11/ContainerTest.php',
        'Pimple\\Tests\\Psr11\\ServiceLocatorTest' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/Psr11/ServiceLocatorTest.php',
        'Pimple\\Tests\\ServiceIteratorTest' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/ServiceIteratorTest.php',
        'Psr\\Container\\ContainerExceptionInterface' => __DIR__ . '/..' . '/psr/container/src/ContainerExceptionInterface.php',
        'Psr\\Container\\ContainerInterface' => __DIR__ . '/..' . '/psr/container/src/ContainerInterface.php',
        'Psr\\Container\\NotFoundExceptionInterface' => __DIR__ . '/..' . '/psr/container/src/NotFoundExceptionInterface.php',
        'PublishPress\\Checklists\\Core\\Container' => __DIR__ . '/../..' . '/core/Container.php',
        'PublishPress\\Checklists\\Core\\ErrorHandler' => __DIR__ . '/../..' . '/core/ErrorHandler.php',
        'PublishPress\\Checklists\\Core\\Factory' => __DIR__ . '/../..' . '/core/Factory.php',
        'PublishPress\\Checklists\\Core\\Legacy\\LegacyPlugin' => __DIR__ . '/../..' . '/core/Legacy/LegacyPlugin.php',
        'PublishPress\\Checklists\\Core\\Legacy\\Module' => __DIR__ . '/../..' . '/core/Legacy/Module.php',
        'PublishPress\\Checklists\\Core\\Legacy\\Util' => __DIR__ . '/../..' . '/core/Legacy/Util.php',
        'PublishPress\\Checklists\\Core\\Plugin' => __DIR__ . '/../..' . '/core/Plugin.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Approved_by' => __DIR__ . '/../..' . '/core/Requirement/Approved_by.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Base_counter' => __DIR__ . '/../..' . '/core/Requirement/Base_counter.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Base_dropdown' => __DIR__ . '/../..' . '/core/Requirement/Base_dropdown.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Base_multiple' => __DIR__ . '/../..' . '/core/Requirement/Base_multiple.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Base_requirement' => __DIR__ . '/../..' . '/core/Requirement/Base_requirement.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Base_simple' => __DIR__ . '/../..' . '/core/Requirement/Base_simple.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Categories_count' => __DIR__ . '/../..' . '/core/Requirement/Categories_count.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Custom_item' => __DIR__ . '/../..' . '/core/Requirement/Custom_item.php',
        'PublishPress\\Checklists\\Core\\Requirement\\External_links' => __DIR__ . '/../..' . '/core/Requirement/External_links.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Featured_image' => __DIR__ . '/../..' . '/core/Requirement/Featured_image.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Filled_excerpt' => __DIR__ . '/../..' . '/core/Requirement/Filled_excerpt.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Image_alt' => __DIR__ . '/../..' . '/core/Requirement/Image_alt.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Interface_parametrized' => __DIR__ . '/../..' . '/core/Requirement/Interface_parametrized.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Interface_required' => __DIR__ . '/../..' . '/core/Requirement/Interface_required.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Internal_links' => __DIR__ . '/../..' . '/core/Requirement/Internal_links.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Tags_count' => __DIR__ . '/../..' . '/core/Requirement/Tags_count.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Taxonomies_count' => __DIR__ . '/../..' . '/core/Requirement/Taxonomies_count.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Title_count' => __DIR__ . '/../..' . '/core/Requirement/Title_count.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Validate_links' => __DIR__ . '/../..' . '/core/Requirement/Validate_links.php',
        'PublishPress\\Checklists\\Core\\Requirement\\Words_count' => __DIR__ . '/../..' . '/core/Requirement/Words_count.php',
        'PublishPress\\Checklists\\Core\\Services' => __DIR__ . '/../..' . '/core/Services.php',
        'PublishPress\\Checklists\\Core\\TemplateLoader' => __DIR__ . '/../..' . '/core/TemplateLoader.php',
        'PublishPress\\Checklists\\Core\\Utils\\HyperlinkExtractor' => __DIR__ . '/../..' . '/core/Utils/HyperlinkExtractor.php',
        'PublishPress\\Checklists\\Core\\Utils\\HyperlinkValidator' => __DIR__ . '/../..' . '/core/Utils/HyperlinkValidator.php',
        'PublishPress\\Checklists\\Permalinks\\Requirement\\ValidChars' => __DIR__ . '/../..' . '/modules/permalinks/lib/Requirement/ValidChars.php',
        'PublishPress\\Checklists\\Yoastseo\\Requirement\\Readability_Analysis' => __DIR__ . '/../..' . '/modules/yoastseo/lib/Requirement/Readability_Analysis.php',
        'PublishPress\\Checklists\\Yoastseo\\Requirement\\Seo_Analysis' => __DIR__ . '/../..' . '/modules/yoastseo/lib/Requirement/Seo_Analysis.php',
        'Symfony\\Polyfill\\Ctype\\Ctype' => __DIR__ . '/..' . '/symfony/polyfill-ctype/Ctype.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit45cb8eb27466eeeb46b871d499268c4e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit45cb8eb27466eeeb46b871d499268c4e::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit45cb8eb27466eeeb46b871d499268c4e::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit45cb8eb27466eeeb46b871d499268c4e::$classMap;

        }, null, ClassLoader::class);
    }
}
