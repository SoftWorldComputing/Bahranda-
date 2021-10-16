<?php
return [
   "permissions" => [
      ['permission' => 'view dashboard', 'description' => 'This user can see content of the dashboard', "category" => "Dashboard"],
      ['permission' => 'create admin', 'description' => 'This user can create new admin', "category" => "Admin Management"],
      ['permission' => 'create roles', 'description' => 'This user can create new roles', "category" => "Roles Management"],
      ['permission' => 'view admins', 'description' => 'This user can view admins', "category" => "Admin Management"],
      ['permission' => 'edit admin', 'description' => 'This user can edit admins', "category" => "Admin Management"],
      ['permission' => 'delete admin', 'description' =>  'This user can delete admins', "category" => "Admin Management"],
      ['permission' => 'view users', 'description' =>  'This admin can view users', "category" => "User Management"],
      ['permission' => 'suspend user', 'description' =>  'This admin can suspend users', "category" => "User Management"],
      ['permission' => 'view all admin', 'description' => 'This user can see a list of admins', "category" => "Admin Management"],
      ['permission' => 'view all roles', 'description' => 'This user can see a list of roles created on the system', "category" => "Roles Management"],
      ['permission' => 'update role', 'description' => 'This user can update role details', "category" => "Roles Management"],
      ['permission' => 'remove role', 'description' => 'This user can remove  roles', "category" => "Roles Management"],
      ['permission' => 'list commodity', 'description' => 'This user can see all commodities', "category" => "Commodity Management"],
      ['permission' => 'add commodity', 'description' => 'This user can add commodities', "category" => "Commodity Management"],
      ['permission' => 'show commodity', 'description' => 'This user can view all the details about a commodity', "category" => "Commodity Management"],
      ['permission' => 'edit commodity', 'description' => 'This user edit details of a commodity', "category" => "Commodity Management"],
      ['permission' => 'delete commodity', 'description' => 'This user delete a commodity', "category" => "Commodity Management"],
      ['permission' => 'commodity price', 'description' => 'This user can edit and create commodity price', "category" => "Commodity Management"],
      ['permission' => 'add new batch', 'description' => 'This user can enter new batches for commodity', 'category' => 'Commodity Management'],
      ['permission' => 'change batch', 'description' => 'This user can change batch for commodity', 'category' => 'Commodity Management'],
      ['permission' => 'view batch history', 'description' => 'This user see history of a particular batch', 'category' => 'Commodity Management'],
      ['permission' => 'authorize price upload', 'description' => 'This user authorize commodity price upload', 'category' => 'Commodity Management'],
      ['permission' => 'see all warehouse', 'description' => 'This user view all warehouses', 'category' => 'Warehouse Management'],
      ['permission' => 'edit warehouse', 'description' => 'This user can edit warehouse details', 'category' => 'Warehouse Management'],
      ['permission' => 'checkout warehouse', 'description' => 'This user can checkout commodities from warehouse', 'category' => 'Warehouse Management'],
      ['permission' => 'add warehouse', 'description' => 'This user can add new warehouse', 'category' => 'Warehouse Management'],
      ['permission' => 'authorize checkout', 'description' => 'This user can authorize authorize checkout from warehouse', 'category' => 'Warehouse Management'],
      ['permission' => 'view warehouse', 'description' => 'This user can see warehouse details', 'category' => 'Warehouse Management'],
      ['permission' => 'see all deals', 'description' => 'This user can see list of all deals', 'category' => 'Deal Management'],
      ['permission' => 'change deal status', 'description' => 'This user can change deal status', 'category' => 'Deal Management'],
      ['permission' => 'assign deal to warehouse', 'description' => 'This user can change assign deal to warehouse', 'category' => 'Deal Management'],
      ['permission' => 'update real return', 'description' => 'This user can update real return', 'category' => 'Deal Management'],

      ['permission' => 'site settings', 'description' => 'This user can change the site settings', 'category' => 'Site Management'],

      ['permission' => 'withdrawal requests list', 'description' => 'This user can access withdrawal request', 'category' => 'Withdrawal Management'],

      ['permission' => 'withdrawal requests authorize', 'description' => 'This user can authroize withdrawal request', 'category' => 'Withdrawal Management'],
      ['permission' => 'list accounting', 'description' => 'This user can view accounting tab', 'category' => 'Accounting Management'],
   ]
];
