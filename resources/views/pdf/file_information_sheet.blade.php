<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans m-0 p-0">
    <div class="max-w-2xl mx-auto my-2 p-2 rounded-lg">
        <img src="{{ public_path('/images/logo.png') }}" alt="Logo" class="mx-auto mb-2 h-14">
        <h1 class="text-center text-xl mb-5">Employee Information</h1>
        <div class="text-center mb-5">
            @if ($employee->photo_link)
                <img src="{{ $employee->photo_link }}" alt="Employee Photo" class="rounded-lg w-32 h-40 mx-auto object-cover">
            @else
                <img src="default-photo.png" alt="Employee Photo" class="rounded-lg w-32 h-40 mx-auto object-cover">
            @endif
        </div>
        <table class="w-full border-collapse">
            <tr>
                <th class="p-2 font-bold bg-gray-200 text-left">First Name</th>
                <td class="p-2">{{ $employee->first_name }}</td>
            </tr>
            <tr>
                <th class="p-2 font-bold bg-gray-200 text-left">Middle Name</th>
                <td class="p-2">{{ $employee->middle_name }}</td>
            </tr>
            <tr>
                <th class="p-2 font-bold bg-gray-200 text-left">Last Name</th>
                <td class="p-2">{{ $employee->last_name }}</td>
            </tr>
            @if ($employee->suffix)
            <tr>
                <th class="p-2 font-bold bg-gray-200 text-left">Suffix</th>
                <td class="p-2">{{ $employee->suffix }}</td>
            </tr>
            @endif
            <tr>
                <th class="p-2 font-bold bg-gray-200 text-left">Birthdate</th>
                <td class="p-2">{{ \Carbon\Carbon::parse($employee->birthdate)->format('F j, Y') }}</td>
            </tr>
            <tr>
                <th class="p-2 font-bold bg-gray-200 text-left">Age</th>
                <td class="p-2">{{ $employee->age }}</td>
            </tr>
            <tr>
                <th class="p-2 font-bold bg-gray-200 text-left">Mobile Number</th>
                <td class="p-2">{{ $employee->mobile_number }}</td>
            </tr>
            <tr>
                <th class="p-2 font-bold bg-gray-200 text-left">Email</th>
                <td class="p-2">{{ $employee->email }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
