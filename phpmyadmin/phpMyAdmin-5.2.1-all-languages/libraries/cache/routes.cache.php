<?php return array (
  0 => 
  array (
    'GET' => 
    array (
      '' => 'PhpMyAdmin\\Controllers\\HomeController',
      '/' => 'PhpMyAdmin\\Controllers\\HomeController',
      '/browse-foreigners' => 'PhpMyAdmin\\Controllers\\BrowseForeignersController',
      '/changelog' => 'PhpMyAdmin\\Controllers\\ChangeLogController',
      '/check-relations' => 'PhpMyAdmin\\Controllers\\CheckRelationsController',
      '/database/central-columns' => 'PhpMyAdmin\\Controllers\\Database\\CentralColumnsController',
      '/database/data-dictionary' => 'PhpMyAdmin\\Controllers\\Database\\DataDictionaryController',
      '/database/designer' => 'PhpMyAdmin\\Controllers\\Database\\DesignerController',
      '/database/events' => 'PhpMyAdmin\\Controllers\\Database\\EventsController',
      '/database/export' => 'PhpMyAdmin\\Controllers\\Database\\ExportController',
      '/database/import' => 'PhpMyAdmin\\Controllers\\Database\\ImportController',
      '/database/multi-table-query' => 'PhpMyAdmin\\Controllers\\Database\\MultiTableQueryController',
      '/database/multi-table-query/tables' => 'PhpMyAdmin\\Controllers\\Database\\MultiTableQuery\\TablesController',
      '/database/operations' => 'PhpMyAdmin\\Controllers\\Database\\OperationsController',
      '/database/qbe' => 'PhpMyAdmin\\Controllers\\Database\\QueryByExampleController',
      '/database/routines' => 'PhpMyAdmin\\Controllers\\Database\\RoutinesController',
      '/database/search' => 'PhpMyAdmin\\Controllers\\Database\\SearchController',
      '/database/sql' => 'PhpMyAdmin\\Controllers\\Database\\SqlController',
      '/database/structure' => 'PhpMyAdmin\\Controllers\\Database\\StructureController',
      '/database/structure/real-row-count' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\RealRowCountController',
      '/database/tracking' => 'PhpMyAdmin\\Controllers\\Database\\TrackingController',
      '/database/triggers' => 'PhpMyAdmin\\Controllers\\Database\\TriggersController',
      '/error-report' => 'PhpMyAdmin\\Controllers\\ErrorReportController',
      '/export' => 'PhpMyAdmin\\Controllers\\Export\\ExportController',
      '/export/check-time-out' => 'PhpMyAdmin\\Controllers\\Export\\CheckTimeOutController',
      '/gis-data-editor' => 'PhpMyAdmin\\Controllers\\GisDataEditorController',
      '/git-revision' => 'PhpMyAdmin\\Controllers\\GitInfoController',
      '/import' => 'PhpMyAdmin\\Controllers\\Import\\ImportController',
      '/import-status' => 'PhpMyAdmin\\Controllers\\Import\\StatusController',
      '/license' => 'PhpMyAdmin\\Controllers\\LicenseController',
      '/lint' => 'PhpMyAdmin\\Controllers\\LintController',
      '/logout' => 'PhpMyAdmin\\Controllers\\LogoutController',
      '/navigation' => 'PhpMyAdmin\\Controllers\\NavigationController',
      '/normalization' => 'PhpMyAdmin\\Controllers\\NormalizationController',
      '/phpinfo' => 'PhpMyAdmin\\Controllers\\PhpInfoController',
      '/preferences/export' => 'PhpMyAdmin\\Controllers\\Preferences\\ExportController',
      '/preferences/features' => 'PhpMyAdmin\\Controllers\\Preferences\\FeaturesController',
      '/preferences/import' => 'PhpMyAdmin\\Controllers\\Preferences\\ImportController',
      '/preferences/main-panel' => 'PhpMyAdmin\\Controllers\\Preferences\\MainPanelController',
      '/preferences/manage' => 'PhpMyAdmin\\Controllers\\Preferences\\ManageController',
      '/preferences/navigation' => 'PhpMyAdmin\\Controllers\\Preferences\\NavigationController',
      '/preferences/sql' => 'PhpMyAdmin\\Controllers\\Preferences\\SqlController',
      '/preferences/two-factor' => 'PhpMyAdmin\\Controllers\\Preferences\\TwoFactorController',
      '/recent-table' => 'PhpMyAdmin\\Controllers\\RecentTablesListController',
      '/schema-export' => 'PhpMyAdmin\\Controllers\\SchemaExportController',
      '/server/binlog' => 'PhpMyAdmin\\Controllers\\Server\\BinlogController',
      '/server/collations' => 'PhpMyAdmin\\Controllers\\Server\\CollationsController',
      '/server/databases' => 'PhpMyAdmin\\Controllers\\Server\\DatabasesController',
      '/server/engines' => 'PhpMyAdmin\\Controllers\\Server\\EnginesController',
      '/server/export' => 'PhpMyAdmin\\Controllers\\Server\\ExportController',
      '/server/import' => 'PhpMyAdmin\\Controllers\\Server\\ImportController',
      '/server/plugins' => 'PhpMyAdmin\\Controllers\\Server\\PluginsController',
      '/server/privileges' => 'PhpMyAdmin\\Controllers\\Server\\PrivilegesController',
      '/server/replication' => 'PhpMyAdmin\\Controllers\\Server\\ReplicationController',
      '/server/sql' => 'PhpMyAdmin\\Controllers\\Server\\SqlController',
      '/server/status' => 'PhpMyAdmin\\Controllers\\Server\\Status\\StatusController',
      '/server/status/advisor' => 'PhpMyAdmin\\Controllers\\Server\\Status\\AdvisorController',
      '/server/status/monitor' => 'PhpMyAdmin\\Controllers\\Server\\Status\\MonitorController',
      '/server/status/processes' => 'PhpMyAdmin\\Controllers\\Server\\Status\\ProcessesController',
      '/server/status/queries' => 'PhpMyAdmin\\Controllers\\Server\\Status\\QueriesController',
      '/server/status/variables' => 'PhpMyAdmin\\Controllers\\Server\\Status\\VariablesController',
      '/server/user-groups' => 'PhpMyAdmin\\Controllers\\Server\\UserGroupsController',
      '/server/user-groups/edit-form' => 'PhpMyAdmin\\Controllers\\Server\\UserGroupsFormController',
      '/server/variables' => 'PhpMyAdmin\\Controllers\\Server\\VariablesController',
      '/sql' => 'PhpMyAdmin\\Controllers\\Sql\\SqlController',
      '/sql/get-default-fk-check-value' => 'PhpMyAdmin\\Controllers\\Sql\\DefaultForeignKeyCheckValueController',
      '/table/add-field' => 'PhpMyAdmin\\Controllers\\Table\\AddFieldController',
      '/table/change' => 'PhpMyAdmin\\Controllers\\Table\\ChangeController',
      '/table/chart' => 'PhpMyAdmin\\Controllers\\Table\\ChartController',
      '/table/create' => 'PhpMyAdmin\\Controllers\\Table\\CreateController',
      '/table/export' => 'PhpMyAdmin\\Controllers\\Table\\ExportController',
      '/table/find-replace' => 'PhpMyAdmin\\Controllers\\Table\\FindReplaceController',
      '/table/get-field' => 'PhpMyAdmin\\Controllers\\Table\\GetFieldController',
      '/table/gis-visualization' => 'PhpMyAdmin\\Controllers\\Table\\GisVisualizationController',
      '/table/import' => 'PhpMyAdmin\\Controllers\\Table\\ImportController',
      '/table/indexes' => 'PhpMyAdmin\\Controllers\\Table\\IndexesController',
      '/table/indexes/rename' => 'PhpMyAdmin\\Controllers\\Table\\IndexRenameController',
      '/table/operations' => 'PhpMyAdmin\\Controllers\\Table\\OperationsController',
      '/table/recent-favorite' => 'PhpMyAdmin\\Controllers\\Table\\RecentFavoriteController',
      '/table/relation' => 'PhpMyAdmin\\Controllers\\Table\\RelationController',
      '/table/replace' => 'PhpMyAdmin\\Controllers\\Table\\ReplaceController',
      '/table/search' => 'PhpMyAdmin\\Controllers\\Table\\SearchController',
      '/table/sql' => 'PhpMyAdmin\\Controllers\\Table\\SqlController',
      '/table/structure' => 'PhpMyAdmin\\Controllers\\Table\\StructureController',
      '/table/structure/change' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\ChangeController',
      '/table/tracking' => 'PhpMyAdmin\\Controllers\\Table\\TrackingController',
      '/table/triggers' => 'PhpMyAdmin\\Controllers\\Table\\TriggersController',
      '/table/zoom-search' => 'PhpMyAdmin\\Controllers\\Table\\ZoomSearchController',
      '/themes' => 'PhpMyAdmin\\Controllers\\ThemesController',
      '/transformation/overview' => 'PhpMyAdmin\\Controllers\\Transformation\\OverviewController',
      '/transformation/wrapper' => 'PhpMyAdmin\\Controllers\\Transformation\\WrapperController',
      '/user-password' => 'PhpMyAdmin\\Controllers\\UserPasswordController',
      '/version-check' => 'PhpMyAdmin\\Controllers\\VersionCheckController',
      '/view/create' => 'PhpMyAdmin\\Controllers\\View\\CreateController',
      '/view/operations' => 'PhpMyAdmin\\Controllers\\View\\OperationsController',
    ),
    'POST' => 
    array (
      '' => 'PhpMyAdmin\\Controllers\\HomeController',
      '/' => 'PhpMyAdmin\\Controllers\\HomeController',
      '/browse-foreigners' => 'PhpMyAdmin\\Controllers\\BrowseForeignersController',
      '/check-relations' => 'PhpMyAdmin\\Controllers\\CheckRelationsController',
      '/collation-connection' => 'PhpMyAdmin\\Controllers\\CollationConnectionController',
      '/columns' => 'PhpMyAdmin\\Controllers\\ColumnController',
      '/config/get' => 'PhpMyAdmin\\Controllers\\Config\\GetConfigController',
      '/config/set' => 'PhpMyAdmin\\Controllers\\Config\\SetConfigController',
      '/database/central-columns' => 'PhpMyAdmin\\Controllers\\Database\\CentralColumnsController',
      '/database/central-columns/populate' => 'PhpMyAdmin\\Controllers\\Database\\CentralColumns\\PopulateColumnsController',
      '/database/designer' => 'PhpMyAdmin\\Controllers\\Database\\DesignerController',
      '/database/events' => 'PhpMyAdmin\\Controllers\\Database\\EventsController',
      '/database/export' => 'PhpMyAdmin\\Controllers\\Database\\ExportController',
      '/database/import' => 'PhpMyAdmin\\Controllers\\Database\\ImportController',
      '/database/multi-table-query/query' => 'PhpMyAdmin\\Controllers\\Database\\MultiTableQuery\\QueryController',
      '/database/operations' => 'PhpMyAdmin\\Controllers\\Database\\OperationsController',
      '/database/operations/collation' => 'PhpMyAdmin\\Controllers\\Database\\Operations\\CollationController',
      '/database/qbe' => 'PhpMyAdmin\\Controllers\\Database\\QueryByExampleController',
      '/database/routines' => 'PhpMyAdmin\\Controllers\\Database\\RoutinesController',
      '/database/search' => 'PhpMyAdmin\\Controllers\\Database\\SearchController',
      '/database/sql' => 'PhpMyAdmin\\Controllers\\Database\\SqlController',
      '/database/sql/autocomplete' => 'PhpMyAdmin\\Controllers\\Database\\SqlAutoCompleteController',
      '/database/sql/format' => 'PhpMyAdmin\\Controllers\\Database\\SqlFormatController',
      '/database/structure' => 'PhpMyAdmin\\Controllers\\Database\\StructureController',
      '/database/structure/add-prefix' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\AddPrefixController',
      '/database/structure/add-prefix-table' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\AddPrefixTableController',
      '/database/structure/central-columns/add' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\CentralColumns\\AddController',
      '/database/structure/central-columns/make-consistent' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\CentralColumns\\MakeConsistentController',
      '/database/structure/central-columns/remove' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\CentralColumns\\RemoveController',
      '/database/structure/change-prefix-form' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\ChangePrefixFormController',
      '/database/structure/copy-form' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\CopyFormController',
      '/database/structure/copy-table' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\CopyTableController',
      '/database/structure/copy-table-with-prefix' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\CopyTableWithPrefixController',
      '/database/structure/drop-form' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\DropFormController',
      '/database/structure/drop-table' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\DropTableController',
      '/database/structure/empty-form' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\EmptyFormController',
      '/database/structure/empty-table' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\EmptyTableController',
      '/database/structure/favorite-table' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\FavoriteTableController',
      '/database/structure/real-row-count' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\RealRowCountController',
      '/database/structure/replace-prefix' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\ReplacePrefixController',
      '/database/structure/show-create' => 'PhpMyAdmin\\Controllers\\Database\\Structure\\ShowCreateController',
      '/database/tracking' => 'PhpMyAdmin\\Controllers\\Database\\TrackingController',
      '/database/triggers' => 'PhpMyAdmin\\Controllers\\Database\\TriggersController',
      '/databases' => 'PhpMyAdmin\\Controllers\\DatabaseController',
      '/error-report' => 'PhpMyAdmin\\Controllers\\ErrorReportController',
      '/export' => 'PhpMyAdmin\\Controllers\\Export\\ExportController',
      '/export/tables' => 'PhpMyAdmin\\Controllers\\Export\\TablesController',
      '/export/template/create' => 'PhpMyAdmin\\Controllers\\Export\\Template\\CreateController',
      '/export/template/delete' => 'PhpMyAdmin\\Controllers\\Export\\Template\\DeleteController',
      '/export/template/load' => 'PhpMyAdmin\\Controllers\\Export\\Template\\LoadController',
      '/export/template/update' => 'PhpMyAdmin\\Controllers\\Export\\Template\\UpdateController',
      '/gis-data-editor' => 'PhpMyAdmin\\Controllers\\GisDataEditorController',
      '/git-revision' => 'PhpMyAdmin\\Controllers\\GitInfoController',
      '/import' => 'PhpMyAdmin\\Controllers\\Import\\ImportController',
      '/import/simulate-dml' => 'PhpMyAdmin\\Controllers\\Import\\SimulateDmlController',
      '/import-status' => 'PhpMyAdmin\\Controllers\\Import\\StatusController',
      '/lint' => 'PhpMyAdmin\\Controllers\\LintController',
      '/logout' => 'PhpMyAdmin\\Controllers\\LogoutController',
      '/navigation' => 'PhpMyAdmin\\Controllers\\NavigationController',
      '/normalization' => 'PhpMyAdmin\\Controllers\\NormalizationController',
      '/preferences/export' => 'PhpMyAdmin\\Controllers\\Preferences\\ExportController',
      '/preferences/features' => 'PhpMyAdmin\\Controllers\\Preferences\\FeaturesController',
      '/preferences/import' => 'PhpMyAdmin\\Controllers\\Preferences\\ImportController',
      '/preferences/main-panel' => 'PhpMyAdmin\\Controllers\\Preferences\\MainPanelController',
      '/preferences/manage' => 'PhpMyAdmin\\Controllers\\Preferences\\ManageController',
      '/preferences/navigation' => 'PhpMyAdmin\\Controllers\\Preferences\\NavigationController',
      '/preferences/sql' => 'PhpMyAdmin\\Controllers\\Preferences\\SqlController',
      '/preferences/two-factor' => 'PhpMyAdmin\\Controllers\\Preferences\\TwoFactorController',
      '/recent-table' => 'PhpMyAdmin\\Controllers\\RecentTablesListController',
      '/schema-export' => 'PhpMyAdmin\\Controllers\\SchemaExportController',
      '/server/binlog' => 'PhpMyAdmin\\Controllers\\Server\\BinlogController',
      '/server/databases' => 'PhpMyAdmin\\Controllers\\Server\\DatabasesController',
      '/server/databases/create' => 'PhpMyAdmin\\Controllers\\Server\\Databases\\CreateController',
      '/server/databases/destroy' => 'PhpMyAdmin\\Controllers\\Server\\Databases\\DestroyController',
      '/server/export' => 'PhpMyAdmin\\Controllers\\Server\\ExportController',
      '/server/import' => 'PhpMyAdmin\\Controllers\\Server\\ImportController',
      '/server/privileges' => 'PhpMyAdmin\\Controllers\\Server\\PrivilegesController',
      '/server/privileges/account-lock' => 'PhpMyAdmin\\Controllers\\Server\\Privileges\\AccountLockController',
      '/server/privileges/account-unlock' => 'PhpMyAdmin\\Controllers\\Server\\Privileges\\AccountUnlockController',
      '/server/replication' => 'PhpMyAdmin\\Controllers\\Server\\ReplicationController',
      '/server/sql' => 'PhpMyAdmin\\Controllers\\Server\\SqlController',
      '/server/status/monitor/chart' => 'PhpMyAdmin\\Controllers\\Server\\Status\\Monitor\\ChartingDataController',
      '/server/status/monitor/slow-log' => 'PhpMyAdmin\\Controllers\\Server\\Status\\Monitor\\SlowLogController',
      '/server/status/monitor/general-log' => 'PhpMyAdmin\\Controllers\\Server\\Status\\Monitor\\GeneralLogController',
      '/server/status/monitor/log-vars' => 'PhpMyAdmin\\Controllers\\Server\\Status\\Monitor\\LogVarsController',
      '/server/status/monitor/query' => 'PhpMyAdmin\\Controllers\\Server\\Status\\Monitor\\QueryAnalyzerController',
      '/server/status/processes' => 'PhpMyAdmin\\Controllers\\Server\\Status\\ProcessesController',
      '/server/status/processes/refresh' => 'PhpMyAdmin\\Controllers\\Server\\Status\\Processes\\RefreshController',
      '/server/status/variables' => 'PhpMyAdmin\\Controllers\\Server\\Status\\VariablesController',
      '/server/user-groups' => 'PhpMyAdmin\\Controllers\\Server\\UserGroupsController',
      '/sql' => 'PhpMyAdmin\\Controllers\\Sql\\SqlController',
      '/sql/get-relational-values' => 'PhpMyAdmin\\Controllers\\Sql\\RelationalValuesController',
      '/sql/get-enum-values' => 'PhpMyAdmin\\Controllers\\Sql\\EnumValuesController',
      '/sql/get-set-values' => 'PhpMyAdmin\\Controllers\\Sql\\SetValuesController',
      '/sql/set-column-preferences' => 'PhpMyAdmin\\Controllers\\Sql\\ColumnPreferencesController',
      '/table/add-field' => 'PhpMyAdmin\\Controllers\\Table\\AddFieldController',
      '/table/change' => 'PhpMyAdmin\\Controllers\\Table\\ChangeController',
      '/table/change/rows' => 'PhpMyAdmin\\Controllers\\Table\\ChangeRowsController',
      '/table/chart' => 'PhpMyAdmin\\Controllers\\Table\\ChartController',
      '/table/create' => 'PhpMyAdmin\\Controllers\\Table\\CreateController',
      '/table/delete/confirm' => 'PhpMyAdmin\\Controllers\\Table\\DeleteConfirmController',
      '/table/delete/rows' => 'PhpMyAdmin\\Controllers\\Table\\DeleteRowsController',
      '/table/export' => 'PhpMyAdmin\\Controllers\\Table\\ExportController',
      '/table/export/rows' => 'PhpMyAdmin\\Controllers\\Table\\ExportRowsController',
      '/table/find-replace' => 'PhpMyAdmin\\Controllers\\Table\\FindReplaceController',
      '/table/get-field' => 'PhpMyAdmin\\Controllers\\Table\\GetFieldController',
      '/table/gis-visualization' => 'PhpMyAdmin\\Controllers\\Table\\GisVisualizationController',
      '/table/import' => 'PhpMyAdmin\\Controllers\\Table\\ImportController',
      '/table/indexes' => 'PhpMyAdmin\\Controllers\\Table\\IndexesController',
      '/table/indexes/rename' => 'PhpMyAdmin\\Controllers\\Table\\IndexRenameController',
      '/table/maintenance/analyze' => 'PhpMyAdmin\\Controllers\\Table\\Maintenance\\AnalyzeController',
      '/table/maintenance/check' => 'PhpMyAdmin\\Controllers\\Table\\Maintenance\\CheckController',
      '/table/maintenance/checksum' => 'PhpMyAdmin\\Controllers\\Table\\Maintenance\\ChecksumController',
      '/table/maintenance/optimize' => 'PhpMyAdmin\\Controllers\\Table\\Maintenance\\OptimizeController',
      '/table/maintenance/repair' => 'PhpMyAdmin\\Controllers\\Table\\Maintenance\\RepairController',
      '/table/partition/analyze' => 'PhpMyAdmin\\Controllers\\Table\\Partition\\AnalyzeController',
      '/table/partition/check' => 'PhpMyAdmin\\Controllers\\Table\\Partition\\CheckController',
      '/table/partition/drop' => 'PhpMyAdmin\\Controllers\\Table\\Partition\\DropController',
      '/table/partition/optimize' => 'PhpMyAdmin\\Controllers\\Table\\Partition\\OptimizeController',
      '/table/partition/rebuild' => 'PhpMyAdmin\\Controllers\\Table\\Partition\\RebuildController',
      '/table/partition/repair' => 'PhpMyAdmin\\Controllers\\Table\\Partition\\RepairController',
      '/table/partition/truncate' => 'PhpMyAdmin\\Controllers\\Table\\Partition\\TruncateController',
      '/table/operations' => 'PhpMyAdmin\\Controllers\\Table\\OperationsController',
      '/table/recent-favorite' => 'PhpMyAdmin\\Controllers\\Table\\RecentFavoriteController',
      '/table/relation' => 'PhpMyAdmin\\Controllers\\Table\\RelationController',
      '/table/replace' => 'PhpMyAdmin\\Controllers\\Table\\ReplaceController',
      '/table/search' => 'PhpMyAdmin\\Controllers\\Table\\SearchController',
      '/table/sql' => 'PhpMyAdmin\\Controllers\\Table\\SqlController',
      '/table/structure' => 'PhpMyAdmin\\Controllers\\Table\\StructureController',
      '/table/structure/add-key' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\AddKeyController',
      '/table/structure/browse' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\BrowseController',
      '/table/structure/central-columns-add' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\CentralColumnsAddController',
      '/table/structure/central-columns-remove' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\CentralColumnsRemoveController',
      '/table/structure/change' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\ChangeController',
      '/table/structure/drop' => 'PhpMyAdmin\\Controllers\\Table\\DropColumnController',
      '/table/structure/drop-confirm' => 'PhpMyAdmin\\Controllers\\Table\\DropColumnConfirmationController',
      '/table/structure/fulltext' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\FulltextController',
      '/table/structure/index' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\AddIndexController',
      '/table/structure/move-columns' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\MoveColumnsController',
      '/table/structure/partitioning' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\PartitioningController',
      '/table/structure/primary' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\PrimaryController',
      '/table/structure/reserved-word-check' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\ReservedWordCheckController',
      '/table/structure/save' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\SaveController',
      '/table/structure/spatial' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\SpatialController',
      '/table/structure/unique' => 'PhpMyAdmin\\Controllers\\Table\\Structure\\UniqueController',
      '/table/tracking' => 'PhpMyAdmin\\Controllers\\Table\\TrackingController',
      '/table/triggers' => 'PhpMyAdmin\\Controllers\\Table\\TriggersController',
      '/table/zoom-search' => 'PhpMyAdmin\\Controllers\\Table\\ZoomSearchController',
      '/tables' => 'PhpMyAdmin\\Controllers\\TableController',
      '/themes/set' => 'PhpMyAdmin\\Controllers\\ThemeSetController',
      '/transformation/overview' => 'PhpMyAdmin\\Controllers\\Transformation\\OverviewController',
      '/transformation/wrapper' => 'PhpMyAdmin\\Controllers\\Transformation\\WrapperController',
      '/user-password' => 'PhpMyAdmin\\Controllers\\UserPasswordController',
      '/version-check' => 'PhpMyAdmin\\Controllers\\VersionCheckController',
      '/view/create' => 'PhpMyAdmin\\Controllers\\View\\CreateController',
      '/view/operations' => 'PhpMyAdmin\\Controllers\\View\\OperationsController',
    ),
  ),
  1 => 
  array (
    'GET' => 
    array (
      0 => 
      array (
        'regex' => '~^(?|/server/engines/([^/]+)|/server/engines/([^/]+)/([^/]+)|/server/variables/get/([^/]+)()())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'PhpMyAdmin\\Controllers\\Server\\ShowEngineController',
            1 => 
            array (
              'engine' => 'engine',
            ),
          ),
          3 => 
          array (
            0 => 'PhpMyAdmin\\Controllers\\Server\\ShowEngineController',
            1 => 
            array (
              'engine' => 'engine',
              'page' => 'page',
            ),
          ),
          4 => 
          array (
            0 => 'PhpMyAdmin\\Controllers\\Server\\Variables\\GetVariableController',
            1 => 
            array (
              'name' => 'name',
            ),
          ),
        ),
      ),
    ),
    'POST' => 
    array (
      0 => 
      array (
        'regex' => '~^(?|/server/status/processes/kill/(\\d+)|/server/variables/set/([^/]+)())$~',
        'routeMap' => 
        array (
          2 => 
          array (
            0 => 'PhpMyAdmin\\Controllers\\Server\\Status\\Processes\\KillController',
            1 => 
            array (
              'id' => 'id',
            ),
          ),
          3 => 
          array (
            0 => 'PhpMyAdmin\\Controllers\\Server\\Variables\\SetVariableController',
            1 => 
            array (
              'name' => 'name',
            ),
          ),
        ),
      ),
    ),
  ),
);