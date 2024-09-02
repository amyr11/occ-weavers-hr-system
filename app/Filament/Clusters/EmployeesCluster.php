<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class EmployeesCluster extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-m-user-group';

    protected static ?int $navigationSort = 1;
}
