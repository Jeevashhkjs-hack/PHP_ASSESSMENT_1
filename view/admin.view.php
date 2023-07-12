<html>
<head>
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="createSongs">
            <form action="/createSongs" method="post">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                    Button
                </button>
            </form>
            <form action="/acceptRequest" method="post">
                <h6 class="text-lg font-bold dark:text-white">Request Users Lists</h6>
                <?php foreach($usersLists as $lists=>$requestUsersList): ?>
                    <li><?php echo $requestUsersList->userName ?></li><button type="submit" name="userName" value="<?php echo $requestUsersList->userName ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" value="<?php echo $requestUsersList->userName ?>">Accept</button>
                <?php endforeach; ?>
            </form>
            <p>premium Users</p>
            <?php foreach($premium as $preuse => $premiumUsr): ?>
                <li><?php echo $premiumUsr->name ?></li>
            <?php endforeach; ?>
            <p>Non Premium Users</p>
            <?php foreach($notpremium as $notpreuse => $notpremiumUsr): ?>
                <li><?php echo $notpremiumUsr->name ?></li>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>