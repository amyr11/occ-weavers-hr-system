<div class="flex items-center gap-2">
	<img src="{{ asset('/images/logo.png') }}" alt="Logo" class="h-10">
	<div class="flex gap-1 items-center">
		<h1 class="font-bold">{{ env('APP_NAME') }}</h1>
		<span class="text-xs px-1.5	 py-0.5 rounded-md border items-center text-center dark:bg-green-950 dark:border-green-700 dark:text-green-500 bg-green-100 border-green-500 text-green-600 font-medium">{{ env('APP_NAME_TAG') }}</span>
	</div>
</div>