<?php
// Include database connection
include 'config.php';

// Check if sheetid is set
if (!isset($_POST['sheetid']) || empty($_POST['sheetid'])) {
    die("Sheet ID is missing.");
}

print_r($_POST);

// Retrieve sheetid
$sheetid = intval($_POST['sheetid']);

// Sanitize and retrieve form fields
$name = mysqli_real_escape_string($conn, $_POST['name']);
$species = mysqli_real_escape_string($conn, $_POST['species']);
$gender = mysqli_real_escape_string($conn, $_POST['gender']);
$age = mysqli_real_escape_string($conn, $_POST['age']);
$skin = mysqli_real_escape_string($conn, $_POST['skin']);
$eyes = mysqli_real_escape_string($conn, $_POST['eyes']);
$hair = mysqli_real_escape_string($conn, $_POST['hair']);
$build = mysqli_real_escape_string($conn, $_POST['build']);
$appearance = mysqli_real_escape_string($conn, $_POST['appearance']);
$agility = intval($_POST['agility']);
$awareness = intval($_POST['awareness']);
$stamina = intval($_POST['stamina']);
$strength = intval($_POST['strength']);
$intellect = intval($_POST['intellect']);
$persuasion = intval($_POST['persuasion']);
$presence = intval($_POST['presence']);
$willpower = intval($_POST['willpower']);
$walkingspeed = intval($_POST['walkingspeed']);
$runningspeed = intval($_POST['runningspeed']);
$sprintingspeed = intval($_POST['sprintingspeed']);
$combatspeed = intval($_POST['combatspeed']);
$currentsanity = intval($_POST['currentsanity']);
$totalsanity = intval($_POST['totalsanity']);
$madness = mysqli_real_escape_string($conn, $_POST['madness']);
$currenthealth = intval($_POST['currenthealth']);
$totalhealth = intval($_POST['totalhealth']);
$desireandmotivation = mysqli_real_escape_string($conn, $_POST['desireandmotivation']);
$experiencepoints = intval($_POST['experiencepoints']);
$characterhistory = mysqli_real_escape_string($conn, $_POST['characterhistory']);
$friendsandallies = mysqli_real_escape_string($conn, $_POST['friendsandallies']);
$knownenemies = mysqli_real_escape_string($conn, $_POST['knownenemies']);
$notablepeople = mysqli_real_escape_string($conn, $_POST['notablepeople']);
$notableexperiences = mysqli_real_escape_string($conn, $_POST['notableexperiences']);
$headgear = mysqli_real_escape_string($conn, $_POST['headgear']);
$torsogear = mysqli_real_escape_string($conn, $_POST['torsogear']);
$armsgear = mysqli_real_escape_string($conn, $_POST['armsgear']);
$legsgear = mysqli_real_escape_string($conn, $_POST['legsgear']);
$bulkpropertiesandother = mysqli_real_escape_string($conn, $_POST['bulkpropertiesandother']);
$damagereduction = mysqli_real_escape_string($conn, $_POST['damagereduction']);
$wealth = mysqli_real_escape_string($conn, $_POST['wealth']);
$propertyandassets = mysqli_real_escape_string($conn, $_POST['propertyandassets']);
$equipment = mysqli_real_escape_string($conn, $_POST['equipment']);
$factionandallegiance = mysqli_real_escape_string($conn, $_POST['factionandallegiance']);
$occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
$patron = mysqli_real_escape_string($conn, $_POST['patron']);
$wastah = mysqli_real_escape_string($conn, $_POST['wastah']);
$enlightenment = mysqli_real_escape_string($conn, $_POST['enlightenment']);
$dislikessecretsandregrets = mysqli_real_escape_string($conn, $_POST['dislikessecretsandregrets']);
$philosophyandprinciples = mysqli_real_escape_string($conn, $_POST['philosophyandprinciples']);
$quirksandhabits = mysqli_real_escape_string($conn, $_POST['quirksandhabits']);
$sayings = mysqli_real_escape_string($conn, $_POST['sayings']);
$homeworld = mysqli_real_escape_string($conn, $_POST['homeworld']);
$ancestryandrelations = mysqli_real_escape_string($conn, $_POST['ancestryandrelations']);
$caste = mysqli_real_escape_string($conn, $_POST['caste']);
$notes = mysqli_real_escape_string($conn, $_POST['notes']);
$attributes = mysqli_real_escape_string($conn, $_POST['attributes']);
$backgrounds = mysqli_real_escape_string($conn, $_POST['backgrounds']);
$talents = mysqli_real_escape_string($conn, $_POST['talents']);
$flaws = mysqli_real_escape_string($conn, $_POST['flaws']);

// Update query
$sql = "UPDATE mwrhwfte_blackvoid.dat_charactersheet SET
    name='$name',
    species='$species',
    gender='$gender',
    age='$age',
    skin='$skin',
    eyes='$eyes',
    hair='$hair',
    build='$build',
    appearance='$appearance',
    agility='$agility',
    awareness='$awareness',
    stamina='$stamina',
    strength='$strength',
    intellect='$intellect',
    persuasion='$persuasion',
    presence='$presence',
    willpower='$willpower',
    walkingspeed='$walkingspeed',
    runningspeed='$runningspeed',
    sprintingspeed='$sprintingspeed',
    combatspeed='$combatspeed',
    currentsanity='$currentsanity',
    totalsanity='$totalsanity',
    madness='$madness',
    currenthealth='$currenthealth',
    totalhealth='$totalhealth',
    desireandmotivation='$desireandmotivation',
    experiencepoints='$experiencepoints',
    characterhistory='$characterhistory',
    friendsandallies='$friendsandallies',
    knownenemies='$knownenemies',
    notablepeople='$notablepeople',
    notableexperiences='$notableexperiences',
    headgear='$headgear',
    torsogear='$torsogear',
    armsgear='$armsgear',
    legsgear='$legsgear',
    bulkpropertiesandother='$bulkpropertiesandother',
    damagereduction='$damagereduction',
    wealth='$wealth',
    propertyandassets='$propertyandassets',
    equipment='$equipment',
    factionandallegiance = '$factionandallegiance',
    occupation = '$occupation',
    patron = '$patron',
    wastah = '$wastah',
    enlightenment = '$enlightenment',
    dislikessecretsandregrets='$dislikessecretsandregrets',
    philosophyandprinciples='$philosophyandprinciples',
    quirksandhabits='$quirksandhabits',
    sayings='$sayings',
    ancestryandrelations='$ancestryandrelations',
    homeworld='$homeworld',
    notes='$notes',
    caste='$caste',
    attributes='$attributes',
    backgrounds='$backgrounds',
    talents='$talents',
    flaws='$flaws'
    WHERE sheetid='$sheetid'";

if (mysqli_query($conn, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

// Start transaction
$conn->begin_transaction();

try {
    if (isset($_POST['rank']) && is_array($_POST['rank'])) {

        // Define the mapping for key traits
        $keyTraitMapping = [
            'Agility' => 1,
            'Awareness' => 2,
            'Stamina' => 3,
            'Strength' => 4,
            'Intellect' => 5,
            'Persuasion' => 6,
            'Presence' => 7,
            'Willpower' => 8,
        ];

        foreach ($_POST['rank'] as $index => $rank) {
            // Sanitize and extract the skill data for the current row
            $skillname = $_POST['skillname'][$index];  // Get the skill name
            $rank = intval($rank);  // Rank value from the form
            $miscmodifier = intval($_POST['miscmodifier'][$index]);  // Misc modifier value
            $keytrait = $_POST['keytrait'][$index];  // Key trait value from the form
            $specialization = $_POST['specialization'][$index];  // Specialization (if any)

            // Map the key trait value to the corresponding number
            if (array_key_exists($keytrait, $keyTraitMapping)) {
                $keytrait = $keyTraitMapping[$keytrait];  // Convert to corresponding number
            } else {
                throw new Exception("Invalid key trait: $keytrait");
            }

            // Assuming skillid corresponds to the index+1 (or some mapping exists)
            $skillid = $index + 1;  // This could be mapped differently if necessary

            // Insert or update the skill data for the current character sheet
            $sql = "INSERT INTO mwrhwfte_blackvoid.dat_userskill (charactersheetid, skillid, skillrank, miscmodifier, keytraitid, specialization)
            VALUES (?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE skillrank = VALUES(skillrank), miscmodifier = VALUES(miscmodifier), keytraitid = VALUES(keytraitid), specialization = VALUES(specialization)";

            // Prepare the SQL statement
            if ($stmt = $conn->prepare($sql)) {
                // Bind the parameters
                $stmt->bind_param("iisiss", $sheetid, $skillid, $rank, $miscmodifier, $keytrait, $specialization);

                // Execute the statement
                if ($stmt->execute()) {
                    echo "Skill $skillname updated successfully.<br>";
                } else {
                    throw new Exception("Error updating skill $skillname: " . $stmt->error . "<br>");
                }

                // Close the statement
                $stmt->close();
            } else {
                throw new Exception("Error preparing query for skill $skillname: " . $conn->error . "<br>");
            }
        }
    } else {
        echo "No skills data received.";
    }

    // Commit transaction
    $conn->commit();
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo $e->getMessage();
}




// Close connection
mysqli_close($conn);
?>