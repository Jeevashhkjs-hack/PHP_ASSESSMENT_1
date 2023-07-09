<html>
<head>
    <title>Share User Select</title>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <form action="/sharedUsers" method="post">
            <?php foreach($usersLists as $users=>$userLists ): ?>
                <div class="mb-6">
                    <label for="large-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><?php echo $userLists->name ?></label>
                    <input id="default-checkbox" name="premiumUsersId[]" type="checkbox" value="<?php echo $userLists->id ?>" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                </div>
            <?php endforeach; ?>
            <button type="submit" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                Share Your Feeling
            </button>
        </form>
    </div>
</body>
</html>