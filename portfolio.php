<?php
session_start();
require 'config.php'; // Database configuration file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <h1 class="text-center page-title">Luke Daoud</h1>
    <hr> 

    <h2 class="list-title">Programming Projects</h2>
    <div class="list-container">
      <ul>
        <li>This Website:</li>
        <p>
            This website is something I personally made, using php (which I didn't know anything about before making it), MySQL, and Apache. It's just a place to host the stuff I like 
            or want, and just like any of my likes or wants, I get them through a bit of work. So I decided to slap this together, and it works, it works well and fast as a simple 
            showcase of what I can do at a foundational level. It's pretty much always WIP, but that's mostly because I want to add more every now and then. As far as technical
            info for the site, the fun stuff includes: spinning up a local instance of the site for testing, architecting the database for scalability for if and when I want to
            add new features without lagging the site, learning about industry standard features to make myself feel better (e.g. this page doesn't have a file extension), and 
            many more boring things that I thought were neat, so I did them.
        </p>
      </ul>
      <ul>
        <li>Food Bot (<a href="https://replit.com/@Skullruss/Food-Bot#main.py" target="_blank">Hosted with Replit</a>):</li>
        <p>
            Ever wanted to go out to eat with a friend, make a suggestion for a restaurant, and hear something like, "Nah, not that place."? 
            Well, no longer. Introducing: Food Bot, a discord bot created using the Discord Python library and hosted on Replit.com, which uses a number of filters to help decide
            where to eat within your parameters quickly and easily. Want to pick a sit-down restaurant? Done. Fancy? Done. Fast? Done. Breakfast? Done. Want to add restaurants?
            Go ahead. Is the bot down for any reason? You don't even need to contact me, go ahead and click run on Replit yourself and it'll start up Food Bot right away! Want to
            give Food Bot a try?
            <A href="https://discord.com/api/oauth2/authorize?client_id=1001247446116081814&permissions=2281826368&scope=bot">Add it to your discord server</A>  and use the command
            "!!help" to get started.
        </p>
      </ul>
      <ul>
        <li>Herald Bot (<a href="https://replit.com/@Skullruss/Server-Bot#main.py" target="_blank">Hosted with Replit</a>):</li>
        <p>
            A few years back, a friend of mine went on his Mormon mission, and that would have him missing for two full years. Two years was quite a bit of time for me and my 
            friends to wait, so I thought it'd be fun and wholesome to create a bot that would calclulate the number of years, months, days, hours, minutes, and seconds until he
            came back, and even report back with one of his nicknames randomly chosen from the list of names we had for him. It's outlived its original purpose, but I repurpose the 
            code from time-to-time for whenver there's a hyped-up event like a movie or game coming out that the whole group is excited for, e.g. Creed III. 
            This is just another moment of wanting something and figuring out how to use my programming knowledge to get it.
        </p>
      </ul>
    </div>

    <h2 class="list-title">Design Projects</h2>
    <div class="list-container">
        <ul>
          <li>Truenamer Rework (<a href="https://docs.google.com/document/d/1W7quYk7BjWgPAUDK3cfaYDz-T1xtHHL1IL2L6-43kWs/edit?usp=sharing" target="_blank">Google Doc</a>):</li>
          <p>
              One of D&D 3rd edition's most notorious design failures. It's a perfect example of fluff being expected to carry crunch, and a wholesale misunderstanding of the 
              numbers that go into balancing a class, especially in the 3.0/3.5 edition of the game which power-scaled nearly every class to never-before-seen heights. This is
              my rework of the Truenamer class, which utilizes the source material for the majority of its effects, but is herein rebalanced to be not only useable, but in 
              the cases in which a player might expect, extremely powerful. This rework is currently used in my D&D group as opposed to the original writeup in the Tome of Magic
              found <a href="https://dndtools.net/classes/truenamer/">here</a> as an example of my ability to parse through what's enjoyable, but broken, and fix it with just 
              as much, if not more quality of life and just as much flavor.
          </p>
        </ul>
        <ul>
            <li>Drunken Master Rework (<a href="https://docs.google.com/document/d/1WMUxkt0ybjlktQ7NbRgOKJ_CJpT-C1-RH9Bw3mGdgLk/edit?usp=sharing" target="_blank">Google Doc</a>):</li>
            <p>
                Another rework I've done is for the Drunken Master class, yet another design mistake by Wizards of the Coast, which neglects the fantasy of being an untouchable 
                monk with barrels of booze in their belly. This rework is currently used in my D&D group as opposed to the original writeup, found 
                <a href="https://dndtools.net/classes/drunken-master/">here</a> as an alternative example of my ability to take a concept poorly executed upon, and deliver 
                what players expect without it being too strong to feel challenged or too weak to feel useful.
            </p>
        </ul>
        <ul>
            <li>Plague Campaign Rules Sheet 
                (<a href="https://docs.google.com/document/d/1GL66O-cH2kkgQDMYICEaVelyMJ3Vb4mvZtgTJrWnJF4/edit?usp=sharing" target="_blank">Google Doc</a>):</li>
            <p>
                I frequently play D&D with my friends, and one day I decided I wanted a hardcore campaign. One with consequences for brash action without thought, and one which
                could keep players on their toes without feeling like an oppressive meat-grinder. So I made this sheet; a compilation of rules for every last bit of simulation
                I might need or want to keep the players tuned in to a low-level campaign. It's not a low level campaign where you kill 2 goblins, rest, and repeat, but it is a 
                campaign where you actually care about money, because it means eating or drinking one more day. One where you care about where you're sleeping, because catching 
                the plague might be a death sentence this time. One where you can absolutely choose to do some side activitiies, but the plague progresses each and every day that 
                passes, and while you might have forgotten, the DM has not.
            </p>
        </ul>
        <ul>
            <li>Cult of Shadows Speech
                (<a href="https://docs.google.com/document/d/1rdGXeMOtwiDGfeQhSSllcTw_xlNBkew5JoBJC-Rqgx4/edit?usp=sharing" target="_blank">Google Doc</a>):</li>
            <p>
                I love planning out my own custom campaigns, all set in the same world with ever-escalating histories as the campaigns are played. One of the constants in this
                world I've made is the God of Shadows, Umbra, and His ironically benevolent cult of worshippers seeking to blot out the sun. Whenever I want something an NPC says to have 
                an actual impact on the players, I usually script it out in a document like this, write and rewrite until it "feels" right, because I think the "feel" of what a character 
                says can completely alter the way that players interact with him or her, subsequently completely altering the way they treat the campaign and whether or not they want to 
                keep playing.
            </p>
        </ul>
        <ul>
            <li>MtG Custom Card Design
                (<a href="https://www.dropbox.com/scl/fo/ef4rcfy2mz78p1h6q5tsd/h?rlkey=5bdci461zau9li5bg9nfzateg&dl=0" target="_blank">Drop Box</a>):</li>
            <p>
                I love playing TCGs, because it's a perfect blend of fluff and crunch; to be able to build something cool and function that is uniquely mine is awesome, every time.
                However, Wizards of the Coast can only make so many cards with so much design space, so I like to make custom cards in my spare time to test the limits of what I 
                can come up with against what can be played without being terrible to play with or against.
            </p>
        </ul>
    </div>

</body>
</html>