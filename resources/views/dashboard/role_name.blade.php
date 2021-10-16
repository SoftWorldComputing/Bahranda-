
@php
$roles = auth('admin')->user() ->roles ->pluck('name') ->toArray();
foreach($roles as $role)
{
    if(auth('admin')->user()->hasRole($role))
    {
        echo ucwords(join(" ",explode('_',$role)));
    }
}
@endphp

