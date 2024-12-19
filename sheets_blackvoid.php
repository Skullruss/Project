<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sheets</title>
    <link rel="stylesheet" href="style.css">

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const sheetId = urlParams.get('sheetid');

        // Function to update the rank modifier based on the rank value
        function updateRankModifier(row) {
            const rankInput = row.querySelector('.rank-input'); // Rank input
            const rankModifierInput = row.querySelector('.rankmodifier-input'); // Rank modifier input

            const rank = parseInt(rankInput.value, 10) || 0; // Get the rank value
            let rankModifier;

            if (rank === -1) {
                rankModifier = -3; // If rank is -1, set modifier to -3
            } else {
                rankModifier = rank; // If rank is >= 0, modifier equals rank
            }

            rankModifierInput.value = rankModifier; // Set the rank modifier value
        }

        // Function to calculate the modifier (make it global)
        function calculateTraitModifier(score) {
            return score - 3;
        }

        function updateTraitModifier(dropdown) {
            const selectedTrait = dropdown.value.toLowerCase(); // Get the selected trait from the dropdown
            const traitInput = document.getElementById(selectedTrait); // Get the trait score input field by trait name

            if (!traitInput) return; // Exit if no corresponding trait input exists

            const traitScore = parseInt(traitInput.value, 10); // Get the trait score from the input field
            const traitModifierField = dropdown.closest('tr').querySelector('.traitmodifier-input'); // Find the trait modifier input field in the same row

            if (!isNaN(traitScore)) {
                const modifier = calculateTraitModifier(traitScore); // Calculate the modifier based on the trait score
                traitModifierField.value = modifier; // Set the trait modifier value in the table
            } else {
                traitModifierField.value = 0; // Default to 0 if no valid score is present
            }

            // Recalculate the total modifier for the row after updating the trait modifier
            calculateTotalModifier(dropdown.closest('tr'));
        }


        // Attach event listeners to all trait dropdowns to trigger the update
        document.addEventListener('DOMContentLoaded', function () {
            // Attach event listeners to all trait dropdowns
            document.querySelectorAll('.trait-dropdown').forEach(dropdown => {
                dropdown.addEventListener('change', function () {
                    updateTraitModifier(this); // Update the trait modifier based on the key trait
                });
            });

            // Attach event listeners to all trait inputs
            document.querySelectorAll('.traits-input[type="number"]').forEach(input => {
                input.addEventListener('input', function () {
                    // Find and update the related trait dropdowns
                    document.querySelectorAll('.trait-dropdown').forEach(dropdown => {
                        if (dropdown.value.toLowerCase() === this.id) {
                            updateTraitModifier(dropdown); // Update trait modifier
                        }
                    });
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            // Fetch character data from the server


            fetch(`fetch_character_data.php?sheetid=${sheetId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        // Check if the error message is related to the user_id
                        if (data.error === "You don't own this page") {
                            console.log("Error caused by user_id mismatch.");
                            // Show an error message or take other actions based on this specific error
                            document.getElementById('error-message').innerText = "You don't own this page.";
                            document.getElementById('error-message').style.display = 'block';
                        } /* else {
                    // Handle other types of errors
                    console.log("Error:", data.error);
                    document.getElementById('error-message').innerText = "An error occurred. Please try again.";
                    document.getElementById('error-message').style.display = 'block';
                        } */
                    } else {
                        // If no error, log the user_id and character data
                        console.log("User ID from session:", data.user_id);
                        console.log("Character Data:", data.character);
                    }

                    // Populate form fields with data
                    document.getElementById('name').value = data.name;
                    document.getElementById('species').value = data.species;
                    document.getElementById('experiencepoints').value = data.experiencepoints;
                    document.getElementById('gender').value = data.gender;
                    document.getElementById('age').value = data.age;
                    document.getElementById('skin').value = data.skin;
                    document.getElementById('eyes').value = data.eyes;
                    document.getElementById('hair').value = data.hair;
                    document.getElementById('build').value = data.build;
                    document.getElementById('appearance').value = data.appearance;
                    document.getElementById('agility').value = data.agility;
                    document.getElementById('awareness').value = data.awareness;
                    document.getElementById('stamina').value = data.stamina;
                    document.getElementById('strength').value = data.strength;
                    document.getElementById('intellect').value = data.intellect;
                    document.getElementById('persuasion').value = data.persuasion;
                    document.getElementById('presence').value = data.presence;
                    document.getElementById('willpower').value = data.willpower;
                    document.getElementById('desireandmotivation').value = data.desireandmotivation;
                    document.getElementById('dislikessecretsandregrets').value = data.dislikessecretsandregrets;
                    document.getElementById('philosophyandprinciples').value = data.philosophyandprinciples;
                    document.getElementById('quirksandhabits').value = data.quirksandhabits;
                    document.getElementById('sayings').value = data.sayings;
                    document.getElementById('ancestryandrelations').value = data.ancestryandrelations;
                    document.getElementById('factionandallegiance').value = data.factionandallegiance;
                    document.getElementById('occupation').value = data.occupation;
                    document.getElementById('patron').value = data.patron;
                    document.getElementById('wastah').value = data.wastah;
                    document.getElementById('enlightenment').value = data.enlightenment;
                    document.getElementById('characterhistory').value = data.characterhistory;
                    document.getElementById('friendsandallies').value = data.friendsandallies;
                    document.getElementById('knownenemies').value = data.knownenemies;
                    document.getElementById('notablepeople').value = data.notablepeople;
                    document.getElementById('notableexperiences').value = data.notableexperiences;
                    document.getElementById('headgear').value = data.headgear;
                    document.getElementById('torsogear').value = data.torsogear;
                    document.getElementById('armsgear').value = data.armsgear;
                    document.getElementById('legsgear').value = data.legsgear;
                    document.getElementById('bulkpropertiesandother').value = data.bulkpropertiesandother;
                    document.getElementById('damagereduction').value = data.damagereduction;
                    document.getElementById('wealth').value = data.wealth;
                    document.getElementById('propertyandassets').value = data.propertyandassets;
                    document.getElementById('equipment').value = data.equipment;
                    document.getElementById('currenthealth').value = data.currenthealth;
                    document.getElementById('totalhealth').value = data.totalhealth;
                    document.getElementById('currentsanity').value = data.currentsanity;
                    document.getElementById('totalsanity').value = data.totalsanity;
                    document.getElementById('walkingspeed').value = data.walkingspeed;
                    document.getElementById('runningspeed').value = data.runningspeed;
                    document.getElementById('sprintingspeed').value = data.sprintingspeed;
                    document.getElementById('combatspeed').value = data.combatspeed;
                    document.getElementById('madness').value = data.madness;
                    document.getElementById('homeworld').value = data.homeworld;
                    document.getElementById('notes').value = data.notes;
                    document.getElementById('attributes').value = data.attributes;
                    document.getElementById('backgrounds').value = data.backgrounds;
                    document.getElementById('talents').value = data.talents;
                    document.getElementById('flaws').value = data.flaws;

                    // Calculate modifiers for each trait after populating data
                    const traits = ['agility', 'awareness', 'stamina', 'strength', 'intellect', 'persuasion', 'presence', 'willpower'];
                    traits.forEach(trait => {
                        const traitInput = document.getElementById(trait);
                        const modifierOutput = document.getElementById(`${trait}_modifier`);
                        if (traitInput && modifierOutput) {
                            const score = parseInt(traitInput.value, 10);
                            if (!isNaN(score)) {
                                modifierOutput.value = calculateTraitModifier(score);
                            }
                        }
                    });
                    updateMadness();
                    updateHealthStatus();
                    const casteDropdown = document.getElementById('caste');
                    casteDropdown.value = data.caste; // Set the selected value from the data

                    // Fetch caste options from the database and populate the dropdown
                    fetch('fetch_caste_options.php') // Create a PHP script to get caste options
                        .then(response => response.json())
                        .then(casteOptions => {
                            casteOptions.forEach(option => {
                                const optionElement = document.createElement('option');
                                optionElement.value = option.casteid;
                                optionElement.text = option.castename;
                                casteDropdown.appendChild(optionElement);
                            });

                            // Set the selected caste value after options are populated
                            casteDropdown.value = data.caste;
                        })
                        .catch(error => console.error('Error fetching caste options:', error));
                })
                .catch(error => {
                    // Handle any other errors (network issues, etc.)
                    document.getElementById('error-message').style.display = 'block';
                });

            // Function to update the modifier based on the input element ID
            function updateModifier(inputId, modifierId) {
                const scoreInput = document.getElementById(inputId);
                const modifierOutput = document.getElementById(modifierId);

                scoreInput.addEventListener('input', function () {
                    const score = parseInt(scoreInput.value, 10);
                    if (!isNaN(score) && score >= 0 && score <= 12) {
                        const modifier = calculateTraitModifier(score);
                        modifierOutput.value = modifier; // Update the modifier field
                    } else {
                        modifierOutput.value = ''; // Clear the modifier field if input is invalid
                    }
                });
            }

            // Apply the updateModifier function to each trait for real-time calculation
            const traits = ['agility', 'awareness', 'stamina', 'strength', 'intellect', 'persuasion', 'presence', 'willpower'];
            traits.forEach(trait => {
                updateModifier(trait, `${trait}_modifier`);
            });

            // Function to calculate the modifier
            function calculateTraitModifier(score) {
                return score - 3;
            }

            // Function to update the modifier based on the input element ID
            function updateModifier(inputId, modifierId) {
                const scoreInput = document.getElementById(inputId);
                const modifierOutput = document.getElementById(modifierId);

                scoreInput.addEventListener('input', function () {
                    let score = parseInt(scoreInput.value, 10);

                    // Validate score input to be between 0 and 12
                    if (isNaN(score)) {
                        score = 0;
                    } else if (score < 0) {
                        score = 0;
                    } else if (score > 12) {
                        score = 12;
                    }

                    scoreInput.value = score; // Ensure the input value stays within the range
                    const modifier = calculateTraitModifier(score);
                    modifierOutput.value = modifier; // Update the modifier field
                });
            }

            // Apply the updateModifier function to each trait
            updateModifier('agility', 'agility_modifier');
            updateModifier('awareness', 'awareness_modifier');
            updateModifier('stamina', 'stamina_modifier');
            updateModifier('strength', 'strength_modifier');
            updateModifier('intellect', 'intellect_modifier');
            updateModifier('persuasion', 'persuasion_modifier');
            updateModifier('presence', 'presence_modifier');
            updateModifier('willpower', 'willpower_modifier');

            const form = document.getElementById('characterSheetForm');
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission behavior

                const formData = new FormData(form);

                // Send the form data via fetch to process_sheet.php
                fetch('process_sheet.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json()) // Expect a JSON response from process_sheet.php
                    .then(data => {
                        const saveMessage = document.getElementById('saveMessage');
                        if (data.success) {
                            saveMessage.textContent = "Character sheet saved successfully!";
                            saveMessage.style.color = "green";
                        } else {
                            saveMessage.textContent = `Error: ${data.error}`;
                            saveMessage.style.color = "red";
                        }
                    })
                    .catch(error => {
                        const saveMessage = document.getElementById('saveMessage');
                        //saveMessage.textContent = "An error occurred while saving the character sheet.";
                        saveMessage.style.color = "red";
                        console.error('Error:', error);
                    });
            });
        });

        function fetchAndPopulateSkills(sheetId) {
            fetch(`fetch_skills.php?sheetid=${sheetId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                        return;
                    }

                    // Key trait mapping for keytraitid to trait names
                    const keyTraitMapping = {
                        1: "Agility",
                        2: "Awareness",
                        3: "Stamina",
                        4: "Strength",
                        5: "Intellect",
                        6: "Persuasion",
                        7: "Presence",
                        8: "Willpower"
                    };

                    // Get all rows from the table
                    const skillRows = document.querySelectorAll('#skills-table tbody tr');

                    // Check if the number of skills and table rows match
                    if (data.length !== skillRows.length) {
                        console.error("Skill data and table rows do not match.");
                        return;
                    }

                    // Iterate through skills from the data and populate the table
                    data.forEach((skill, index) => {
                        const row = skillRows[index];

                        // Populate skill rank
                        row.querySelector('.rank-input').value = skill.skillrank;

                        // Populate misc modifier
                        row.querySelector('.miscmodifier-input').value = skill.miscmodifier;

                        // Populate specialization
                        row.querySelector('.specialization-input').value = skill.specialization;

                        // Populate key trait dropdown
                        const keyTraitDropdown = row.querySelector('.trait-dropdown');
                        if (keyTraitDropdown && keyTraitMapping[skill.keytraitid]) {
                            keyTraitDropdown.value = keyTraitMapping[skill.keytraitid]; // Set the correct trait name in the dropdown

                            // Manually call updateTraitModifier to set the trait modifier for this row
                            updateTraitModifier(keyTraitDropdown);
                        }

                        // Populate rank modifier (rank only)
                        const rank = skill.skillrank || 0;
                        const rankModifier = (rank === -1) ? -3 : rank;
                        row.querySelector('.rankmodifier-input').value = rankModifier;

                        // Calculate total modifier (total includes rank modifier, misc, and trait modifier)
                        const miscModifier = skill.miscmodifier || 0;
                        const traitModifier = row.querySelector('.traitmodifier-input').value || 0;
                        const totalModifier = parseInt(rankModifier) + parseInt(miscModifier) + parseInt(traitModifier);

                        // Update total modifier
                        row.querySelector('.totalmodifier').value = totalModifier;
                    });
                })
                .catch(error => console.error('Error fetching skills data:', error));
        }
        // Example call to fetch and populate skills for a given sheetId


        document.addEventListener('DOMContentLoaded', function () {
            fetchAndPopulateSkills(sheetId); // Replace 3 with the actual sheetId

            function calculateModifiers() {
                // Target rows in the table body (assuming there is only one table)
                document.querySelectorAll('tbody tr').forEach((row, rowIndex) => {
                    // Get the skill name for the row
                    const skillNameInput = row.querySelector('.skillname-input');
                    const skillName = skillNameInput ? skillNameInput.value : 'Unknown Skill';

                    // Get Rank and Rank Modifier
                    const rankInput = row.querySelector('.rank-input');
                    const rankModifierInput = row.querySelector('.rankmodifier-input');
                    if (rankInput && rankModifierInput) {
                        const rank = parseInt(rankInput.value, 10) || 0;
                        const rankModifier = (rank === -1) ? -3 : rank;
                        rankModifierInput.value = rankModifier;
                        console.log(`Row ${rowIndex}: Skill=${skillName}, Rank=${rank}, Rank Modifier=${rankModifier}`);
                    } else {
                        console.error(`Row ${rowIndex}: Skill=${skillName}, Rank input or Rank Modifier input not found`);
                        if (!rankInput) console.error(`Row ${rowIndex}: Skill=${skillName}, Rank input is missing`);
                        if (!rankModifierInput) console.error(`Row ${rowIndex}: Skill=${skillName}, Rank Modifier input is missing`);
                    }

                    // Get Trait and Trait Modifier
                    const traitDropdown = row.querySelector('.trait-dropdown');
                    const traitModifierInput = row.querySelector('.traitmodifier-input');
                    if (traitDropdown && traitModifierInput) {
                        const trait = traitDropdown.value || '';
                        let traitModifier = 0;

                        // Retrieve trait modifiers from global trait elements
                        const traitModifierId = `${trait.toLowerCase()}_modifier`;
                        const traitModifierElement = document.getElementById(traitModifierId);
                        if (traitModifierElement) {
                            traitModifier = parseInt(traitModifierElement.value, 10) || 0;
                        }
                        traitModifierInput.value = traitModifier;
                        console.log(`Row ${rowIndex}: Skill=${skillName}, Trait=${trait}, Trait Modifier=${traitModifier}`);
                    } else {
                        console.error(`Row ${rowIndex}: Skill=${skillName}, Trait dropdown or Trait Modifier input not found`);
                        if (!traitDropdown) console.error(`Row ${rowIndex}: Skill=${skillName}, Trait dropdown is missing`);
                        if (!traitModifierInput) console.error(`Row ${rowIndex}: Skill=${skillName}, Trait Modifier input is missing`);
                    }

                    // Calculate Total Modifier
                    const totalModifierInput = row.querySelector('.totalmodifier');
                    const miscModifierInput = row.querySelector('.miscmodifier-input');
                    if (totalModifierInput && miscModifierInput) {
                        const miscModifier = parseInt(miscModifierInput.value, 10) || 0;
                        const rankModifier = parseInt(row.querySelector('.rankmodifier-input')?.value, 10) || 0;
                        const traitModifier = parseInt(row.querySelector('.traitmodifier-input')?.value, 10) || 0;

                        const totalModifier = rankModifier + traitModifier + miscModifier;
                        totalModifierInput.value = totalModifier;
                        console.log(`Row ${rowIndex}: Skill=${skillName}, Total Modifier=${totalModifier}`);
                    } else {
                        console.error(`Row ${rowIndex}: Skill=${skillName}, Total Modifier input or Misc Modifier input not found`);
                        if (!totalModifierInput) console.error(`Row ${rowIndex}: Skill=${skillName}, Total Modifier input is missing`);
                        if (!miscModifierInput) console.error(`Row ${rowIndex}: Skill=${skillName}, Misc Modifier input is missing`);
                    }
                });
            }

            // Call the calculateModifiers function on page load
            calculateModifiers();
        });

        document.addEventListener('DOMContentLoaded', function () {
            const backgroundids = [];

            // Load the initial background select and description elements
            const initialSelectElement = document.getElementById('background-select');
            const initialDescriptionElement = document.getElementById('background-description');

            // Call the loadBackgrounds function to populate the first background select
            loadBackgrounds(initialSelectElement, initialDescriptionElement, 0);  // Start with slot 0
        });

        function updateMadness() {
            const currentSanity = parseFloat(document.getElementById("currentsanity").value);
            const totalSanity = parseFloat(document.getElementById("totalsanity").value);
            const sanityStatusField = document.getElementById("sanitystatus");
            const madnessField = document.getElementById("madness");

            if (isNaN(currentSanity) || isNaN(totalSanity) || totalSanity === 0) {
                // Clear status if inputs are invalid
                sanityStatusField.value = '';
                return;
            }

            let sanityStatus = "";

            if (currentSanity === 0) {
                sanityStatus = "Raving Mad";
            } else if (currentSanity <= totalSanity / 4) {
                sanityStatus = "Disturbed (+3 to Madness)";
            } else if (currentSanity <= totalSanity / 2) {
                sanityStatus = "Anxious (+1 to Madness)";
            } else if (currentSanity < totalSanity) {
                sanityStatus = "Lucid";
            }
            else {
                sanityStatus = "Rational";
            }

            // Update fields
            sanityStatusField.value = sanityStatus;
        }

        function updateHealthStatus() {
            const currentHealth = parseFloat(document.getElementById("currenthealth").value);
            const totalHealth = parseFloat(document.getElementById("totalhealth").value);
            const healthStatusField = document.getElementById("healthstatus");

            // Ensure the input is valid
            if (isNaN(currentHealth) || isNaN(totalHealth)) {
                healthStatusField.value = '';  // Clear the status if input is invalid
                return;
            }

            let healthStatus = '';

            // Health status conditions
            if (currentHealth >= totalHealth) {
                healthStatus = 'Healthy';
            } else if (currentHealth >= totalHealth / 2) {
                healthStatus = 'Bruised';
            } else if (currentHealth >= totalHealth / 4 && currentHealth < totalHealth / 2) {
                healthStatus = 'Hurt';
            } else if (currentHealth > 0 && currentHealth < totalHealth / 4) {
                healthStatus = 'Injured';
            } else if (currentHealth <= 0 && currentHealth > totalHealth * -0.5) {
                healthStatus = 'Incapacitated';
            } else if (currentHealth <= totalHealth * -0.5) {
                healthStatus = 'Dead';
            }

            // Update the health status field
            healthStatusField.value = healthStatus;
        }

        function adjustRank(button, change) {
            // Get the rank input field
            const rankInput = button.parentElement.querySelector('.rank-input');

            // Get the current rank value and ensure it’s a number
            let currentRank = parseInt(rankInput.value, 10);

            // If the value is not a number, default to -1
            if (isNaN(currentRank)) {
                currentRank = -1;
            }

            // Calculate the new rank value
            let newRank = currentRank + change;

            // Ensure the rank is not below -1 and not above 12
            if (newRank < -1) {
                newRank = -1;
            } else if (newRank > 12) {
                newRank = 12;
            }

            // Update the input field with the new rank
            rankInput.setAttribute('value', newRank); // Use setAttribute for consistency
            rankInput.value = newRank;

            // Trigger the rank modifier update
            updateRankModifier(button.closest('tr'));

            // Trigger the trait modifier update
            updateTraitModifier(button.closest('tr').querySelector('.trait-dropdown'));

            // Recalculate the total modifier for the row
            calculateTotalModifier(button.closest('tr'));

            console.log(`Current Rank: ${currentRank}, New Rank: ${newRank}`);

        }

        // Function to calculate the total modifier
        function calculateTotalModifier(row) {
            // Get the relevant input fields from the same row
            const rankModifier = row.querySelector('input[name="rankmodifier[]"]');
            const traitModifier = row.querySelector('input[name="traitmodifier[]"]');
            const miscModifier = row.querySelector('input[name="miscmodifier[]"]');
            const totalModifier = row.querySelector('input[name="totalmodifier[]"]');

            // Debug output to verify values
            console.log("Rank Modifier:", rankModifier.value);
            console.log("Trait Modifier:", traitModifier.value);
            console.log("Misc Modifier:", miscModifier.value);

            // Calculate the total modifier as the sum of the rank, trait, and misc modifiers
            const total =
                parseInt(rankModifier.value || 0, 10) +
                parseInt(traitModifier.value || 0, 10) +
                parseInt(miscModifier.value || 0, 10);

            // Debug output to check the total calculation
            console.log("Calculated Total Modifier:", total);

            // Set the totalModifier value
            totalModifier.value = total;
        }

        // Attach event listeners to all modifier inputs
        function attachModifierListeners() {
            document.querySelectorAll('.modifier-input').forEach(function (input) {

                input.addEventListener('input', function () {
                    // Find the parent row of the input that triggered the event
                    const row = this.closest('tr');

                    // Debug to confirm that the event is triggered
                    console.log("Input changed in row:", row);

                    // Recalculate the total modifier for this row
                    calculateTotalModifier(row);
                });
            });
        }

        // Call this function once when the page loads to attach all listeners
        window.onload = function () {
            attachModifierListeners();
        };




    </script>

    <script>
        // Function to fetch background data and populate the dropdown
        function loadBackgrounds(selectElement, descriptionElement, slot) {
            fetch('fetch_backgrounds.php')
                .then(response => response.json())
                .then(data => {
                    selectElement.innerHTML = '<option value="" selected disabled>Select Background (Costs Background Points)</option>';

                    // Populate the dropdown with options
                    data.forEach(background => {
                        const option = document.createElement('option');
                        option.value = background.id;
                        option.textContent = background.name;
                        selectElement.appendChild(option);
                    });

                    // Event listener for background selection
                    selectElement.addEventListener('change', function () {
                        const selectedId = parseInt(this.value, 10);

                        if (!isNaN(selectedId)) {
                            const selectedBackground = data.find(bg => bg.id === selectedId);
                            if (selectedBackground) {
                                descriptionElement.value = selectedBackground.description;
                                autoResizeTextarea(descriptionElement);
                                backgroundids[slot] = selectedId;  // Update the corresponding array slot
                                console.log(`Updated backgroundids array: `, backgroundids); // For debugging
                            }
                        } else {
                            descriptionElement.value = '';
                            backgroundids[slot] = null;  // Reset the corresponding array slot if none is selected
                        }
                    });
                })
                .catch(error => console.error('Error loading backgrounds:', error));
        }


        // Function to auto-resize the textarea based on its content
        function autoResizeTextarea(textarea) {
            textarea.style.height = 'auto'; // Reset height
            textarea.style.height = textarea.scrollHeight + 'px'; // Set height to scrollHeight
        }

        // Load backgrounds for the initial section when the page loads
        document.addEventListener('DOMContentLoaded', function () {
            const initialSelectElement = document.getElementById('background-select');
            const initialDescriptionElement = document.getElementById('background-description');
            loadBackgrounds(initialSelectElement, initialDescriptionElement);
        });

    </script>
</head>

<script>
    document.addEventListener('keydown', function (event) {
        // Check if 'Ctrl' key and 'S' key are pressed
        if (event.ctrlKey && event.key === 's') {
            event.preventDefault(); // Prevent the default browser save behavior
            document.getElementById('save-button').click(); // Trigger the save button click
        }
    });
</script>



<body>
    <div id="saveMessage"></div>
    <!-- The error message div -->
    <div id="error-message">YOU DON'T OWN THIS</div>

    <div class="sheet-container">
        <div class="character-form-container">
            <form class="character-form" action="process_sheet.php" method="post" id="characterSheetForm">
                <!-- TODO: add a field for size -->
                <!-- Character Information -->
                <fieldset>
                    <div class="form-group-row">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="species" title="Most likely human, though you may be voidmarked, voidtouched,
 or one of the many '-kin' races in Under Nebulus Skies">Species:</label>
                            <input type="text" id="species" name="species">
                        </div>
                        <div class="form-group">
                            <label for="homeworld"
                                title="World of origin. Find details for both flavor and crunch on page 21 of the Core Rulebook PDF.">Homeworld:</label>
                            <input type="text" id="homeworld" name="homeworld">
                        </div>
                        <div class="form-group">
                            <label for="experiencepoints" title="This is initially Character Points, which are spent differently than Experience Points
for details on how to use experience points, visit page 172 of the Core Rulebook PDF. 
Experience cannot be used to acquire new Attributes, only Character Points may do so.
Neither can a player fully remove a flaw with Experience Points. Backgrounds may be 
acquired using Experience Points with Arbiter Approval.">Experience Points:</label>
                            <input type="number" id="experiencepoints" name="experiencepoints">
                        </div>
                    </div>

                    <div class="form-group-row">
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <input type="text" id="gender" name="gender">
                        </div>

                        <div class="form-group">
                            <label for="age">Age:</label>
                            <input type="text" id="age" name="age">
                        </div>
                        <div class="form-group">
                            <label for="skin">Skin:</label>
                            <input type="text" id="skin" name="skin">
                        </div>
                        <div class="form-group">
                            <label for="eyes">Eyes:</label>
                            <input type="text" id="eyes" name="eyes">
                        </div>
                        <div class="form-group">
                            <label for="hair">Hair:</label>
                            <input type="text" id="hair" name="hair">
                        </div>
                    </div>
                    <div class="form-group-row">
                        <div class="form-group">
                            <label for="build" title="Describes the physical structure and proportions of a character's body. 
E.g. Athletic, Slim, Stocky, Broad-shouldered, Petite, Towering, Wiry, Heavily Muscled.">Build:</label>
                            <input type="text" id="build" name="build">
                        </div>
                        <div class="form-group">
                            <label for="appearance"
                                title="Refers to the visible features, presentation, and overall impression of a character.
E.g. Handsome, Scarred, Well-groomed, Disheveled, Elegant, Rugged, Piercing Eyes, Unique Hairstyle.">Appearance:</label>
                            <input type="text" id="appearance" name="appearance">
                        </div>
                    </div>
        </div>
        </fieldset>

        <!-- Traits -->
        <div class="traits-box">
            <fieldset>
                <div class="form-group-row">
                    <div class="form-group">
                        <label for="agility" title="Your character’s Agility score
shows her general coordination, balance
and motor skills.
- Dexterity in D&D">Agility:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="agility" name="agility" placeholder="Score">
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="text" id="agility_modifier" name="agility_modifier"
                            placeholder="Modifier" readonly>
                    </div>
                </div>

                <div class="form-group-row">
                    <div class="form-group">
                        <label for="awareness" title="Touch,
taste, sight, hearing and smell. Awareness also
indicates an instinctive understanding based on
sensitivity rather than logical reasoning.
- Wisdom in D&D">Awareness:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="awareness" name="awareness" placeholder="Score">
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="text" id="awareness_modifier" name="awareness_modifier"
                            placeholder="Modifier" readonly>
                    </div>
                </div>

                <div class="form-group-row">
                    <div class="form-group">
                        <label for="stamina" title="The Stamina score of your character
determines her state of health and endurance, as well as
resilience to disease, poison and toxins.
- Constitution in D&D">Stamina:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="stamina" name="stamina" placeholder="Score">
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="text" id="stamina_modifier" name="stamina_modifier"
                            placeholder="Modifier" readonly>
                    </div>
                </div>

                <div class="form-group-row">
                    <div class="form-group">
                        <label for="strength" title="This Trait indicates the raw brawn and muscle
of your character.
- Strength in D&D">Strength:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="strength" name="strength" placeholder="Score">
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="text" id="strength_modifier" name="strength_modifier"
                            placeholder="Modifier" readonly>
                    </div>
                </div>

                <div class="form-group-row">
                    <div class="form-group">
                        <label for="intellect" title="Your character’s Intellect ranking indicates
her aptitude for logic and reason, languages, as well as
other learned abilities and memory.
- Intellgence in D&D">Intellect:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="intellect" name="intellect" placeholder="Score">
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="text" id="intellect_modifier" name="intellect_modifier"
                            placeholder="Modifier" readonly>
                    </div>
                </div>

                <div class="form-group-row">
                    <div class="form-group">
                        <label for="persuasion" title="This Trait establishes a character’s ability to
convince, coerce or cunningly influence others by knowingly
appealing to their hopes, desires and needs through
calculated argument and social subtlety.
- Charisma in D&D">Persuasion:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="persuasion" name="persuasion" placeholder="Score">
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="text" id="persuasion_modifier" name="persuasion_modifier"
                            placeholder="Modifier" readonly>
                    </div>
                </div>

                <div class="form-group-row">
                    <div class="form-group">
                        <label for="presence" title="The Presence score denotes the looks, bearing
and charisma your character possesses in social situations. For
humans and other Cosmic species, Presence is the capacity
to grab the attention of others and to inspire admiration and
respect.
- Charisma in D&D">Presence:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="presence" name="presence" placeholder="Score">
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="text" id="presence_modifier" name="presence_modifier"
                            placeholder="Modifier" readonly>
                    </div>
                </div>

                <div class="form-group-row">
                    <div class="form-group">
                        <label for="willpower" title="This trait score determines your character’s
mental fortitude, resolve and resistance to influence from
those who may attempt to manipulate her.
- Wisdom in D&D">Willpower:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="willpower" name="willpower" placeholder="Score">
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="text" id="willpower_modifier" name="willpower_modifier"
                            placeholder="Modifier" readonly>
                    </div>
                </div>
            </fieldset>

            <!-- Speed -->
            <fieldset>
                <div class="form-group-row">
                    <div class="form-group">
                        <label for="walkingspeed">Walking Speed:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="walkingspeed" name="walkingspeed">
                    </div>
                </div>
                <div class="form-group-row">
                    <div class="form-group">
                        <label for="runningspeed">Running Speed:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="runningspeed" name="runningspeed">
                    </div>
                </div>
                <div class="form-group-row">
                    <div class="form-group">
                        <label for="sprintingspeed">Sprinting Speed:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="sprintingspeed" name="sprintingspeed">
                    </div>
                </div>
                <div class="form-group-row">
                    <div class="form-group">
                        <label for="combatspeed">Combat Speed:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="combatspeed" name="combatspeed">
                    </div>
                </div>
            </fieldset>
            <!-- Sanity -->
            <fieldset>
                <div class="form-group-row">
                    <div class="form-group">
                        <label for="currentsanity">Current Sanity:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="currentsanity" name="currentsanity"
                            oninput="updateMadness()">
                    </div>
                </div>

                <div class="form-group-row">
                    <div class="form-group">
                        <label for="totalsanity">Total Sanity:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="totalsanity" name="totalsanity"
                            oninput="updateMadness()">
                    </div>
                </div>

                <div class="form-group-row">
                    <div class="form-group">
                        <label for="sanitystatus">Sanity Status:</label> <!-- Used for showing anxious or disturbed -->
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="text" id="sanitystatus" name="sanitystatus" readonly>
                    </div>
                </div>

                <label for="madness" title="When one or more sanity points are lost the character suffers temporary insanity and must immediately make a
roll on the Madness effect chart to resolve the nature of the madness and determine which detrimental effect the character will suffer.">Madness:</label>
                <textarea class="character-sheet-textarea" id="madness" name="madness"></textarea>
            </fieldset>


            <!-- Health -->
            <fieldset>
                <div class="form-group-row">
                    <div class="form-group">
                        <label for="currenthealth">Current Health:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="currenthealth" name="currenthealth"
                            oninput="updateHealthStatus()">
                    </div>
                </div>

                <div class="form-group-row">
                    <div class="form-group">
                        <label for="totalhealth">Total Health:</label>
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="number" id="totalhealth" name="totalhealth"
                            oninput="updateHealthStatus()">
                    </div>
                </div>

                <div class="form-group-row">
                    <div class="form-group">
                        <label for="healthstatus">Health Status:</label>
                        <!-- Use for Hurt, Injured, and Incapacitated status -->
                    </div>
                    <div class="form-group">
                        <input class="traits-input" type="text" id="healthstatus" name="healthstatus" readonly>
                    </div>
                </div>
            </fieldset>


            <!-- Wealth, Assets, and Equipment -->
            <fieldset>
                <label for="wealth">Wealth:</label>
                <textarea class="character-sheet-textarea" id="wealth" name="wealth"></textarea>

                <label for="propertyandassets">Property and Assets:</label>
                <textarea class="character-sheet-textarea" id="propertyandassets" name="propertyandassets"></textarea>

                <label for="equipment">Equipment:</label>
                <textarea class="character-sheet-textarea" id="equipment" name="equipment"></textarea>
                <!-- 
                <label for="weapons">Weapons:</label>
                <textarea class="character-sheet-textarea" id="weapons" name="weapons"></textarea> -->
            </fieldset>

            <!-- Gear -->
            <fieldset>
                <label for="headgear">Headgear:</label>
                <textarea class="character-sheet-textarea" id="headgear" name="headgear"></textarea>

                <label for="torsogear">Torso Gear:</label>
                <textarea class="character-sheet-textarea" id="torsogear" name="torsogear"></textarea>

                <label for="armsgear">Arms Gear:</label>
                <textarea class="character-sheet-textarea" id="armsgear" name="armsgear"></textarea>

                <label for="legsgear">Legs Gear:</label>
                <textarea class="character-sheet-textarea" id="legsgear" name="legsgear"></textarea>

                <label for="bulkpropertiesandother">Bulk Properties and Other:</label>
                <textarea class="character-sheet-textarea" id="bulkpropertiesandother"
                    name="bulkpropertiesandother"></textarea>

                <label for="damagereduction">Damage Reduction:</label>
                <textarea class="character-sheet-textarea" id="damagereduction" name="damagereduction"></textarea>
            </fieldset>
        </div>


        <!-- Background & Personality -->
        <div class="text-section">
            <fieldset>
                <label for="desireandmotivation"
                    title="What does your character desire and what are their goals?">Desire and Motivation:</label>
                <textarea class="character-sheet-textarea" class="character-sheet-textarea" id="desireandmotivation"
                    name="desireandmotivation"></textarea>

                <label for="dislikessecretsandregrets" title="What does your character abhor, fear or regret? Just as
people are driven by desires, they are repelled by dislikes and aversions.">Dislikes, Secrets, and Regrets:</label>
                <textarea class="character-sheet-textarea" id="dislikessecretsandregrets"
                    name="dislikessecretsandregrets"></textarea>

                <label for="philosophyandprinciples" title="Does your character follow a specific set of values or
principles, a fixed code of conduct or is she perhaps driven solely by impulsive whims and passions?">Philosophy and
                    Principles:</label>
                <textarea class="character-sheet-textarea" id="philosophyandprinciples"
                    name="philosophyandprinciples"></textarea>

                <label for="quirksandhabits" title="Quirks refer to noticeable and usually peculiar behaviour.">Quirks
                    and Habits:</label>
                <textarea class="character-sheet-textarea" id="quirksandhabits" name="quirksandhabits"></textarea>

                <label for="sayings" title="Picking one or two phrases, proverbs or subjects for your character to sporadically 
repeat is also a useful way of depicting personality.">Sayings:</label>
                <textarea class="character-sheet-textarea" id="sayings" name="sayings"></textarea>

                <label for="ancestryandrelations"
                    title="Does your character have any family, relatives or notable friends?">Ancestry and
                    Relations:</label>
                <textarea class="character-sheet-textarea" id="ancestryandrelations"
                    name="ancestryandrelations"></textarea>

                <label for="caste" title="character’s caste defines her place in the hierarchy of Llyhn, determining not only how
she is perceived but also which social restrictions and advantages she is subject to.">Caste:</label>
                <select id="caste" name="caste">
                    <option value="Kalbi">Kalbi</option>
                    <option value="Baltu">Baltu</option>
                    <option value="Shahrvah">Shahrvah</option>
                    <option value="Muati">Muati</option>
                    <option value="Sahrnesh">Sahrnesh</option>
                    <option value="Ma'alu">Ma'alu</option>
                    <option value="Sarru">Sarru</option>
                </select>

                <label for="factionandallegiance" title="Players are free to select one of the known groups of the Black Void setting or, 
with the approval of the Arbiter, create a new one.">Faction and Allegiance:</label>
                <textarea class="character-sheet-textarea" id="factionandallegiance"
                    name="factionandallegiance"></textarea>

                <label for="occupation"
                    title="character’s occupation is somewhat determined by the caste she belongs to and establishes how she earns 
her livelihood. It also provides background and a point of affiliation, which can be built on by a creative Arbiter.">Occupation:</label>
                <textarea class="character-sheet-textarea" id="occupation" name="occupation"></textarea>

                <label for="patron"
                    title="Although it is by no means obligatory, the social stratification and caste system in the Eternal City invites 
people to seek patronage from those more powerful than themselves, in exchange for rendering services to their patron or matron.">Patron:</label>
                <textarea class="character-sheet-textarea" id="patron" name="patron"></textarea>

                <label for="wastah" title="Wastah refers to a character’s network of connections, knowing people in the right places and having the clout to 
make these exert their authority on your behalf. Wastah supercedes caste and status, functioning on a level that allows 
characters influence beyond their caste. Wastah is gained in tiered rankings, see page 179 in the Core Rulebook PDF for more info.
Fun fact - Wastah is Arabic for clout and implies nepotism.">Wastah:</label>
                <textarea class="character-sheet-textarea" id="wastah" name="wastah"></textarea>

                <label for="enlightenment" title="Enlightenment is an inexplicable awareness and comprehension of the mysteries of the Cosmos, Void and the duality 
of existence. Gain enlightenment in tiers, which grants specific abilities found in the Core Rulebook and requires a minimum Awareness of 3.
The first ascension ability any character gets is automatically Void Sensitivity.">Enlightenment:</label>
                <textarea class="character-sheet-textarea" id="enlightenment" name="enlightenment"></textarea>
            </fieldset>
            <fieldset>
                <label for="characterhistory"
                    title="Background information on your character which doesn't fit into any other field.">Character
                    History:</label>
                <textarea class="character-sheet-textarea" id="characterhistory" name="characterhistory"></textarea>

                <label for="friendsandallies"
                    title="For keeping track of less notable friends & allies, e.g. party members.">Friends and
                    Allies:</label>
                <textarea class="character-sheet-textarea" id="friendsandallies" name="friendsandallies"></textarea>

                <label for="knownenemies"
                    title="For keeping track of enemies—yours and your friends'—as they keep track of you.">Known
                    Enemies:</label>
                <textarea class="character-sheet-textarea" id="knownenemies" name="knownenemies"></textarea>

                <label for="notablepeople"
                    title="For keeping track of important names that are neither friend nor foe... yet.">Notable
                    People:</label>
                <textarea class="character-sheet-textarea" id="notablepeople" name="notablepeople"></textarea>

                <label for="notableexperiences"
                    title="A journal entry location for tracking moments your character isn't going to forget">Notable
                    Experiences:</label>
                <textarea class="character-sheet-textarea" id="notableexperiences" name="notableexperiences"></textarea>
            </fieldset>
        </div>

        <label for="notes">Notes:</label>
        <textarea class="character-sheet-textarea" id="notes" name="notes"></textarea>

        <label for="attributes" title="Attributes are physical qualities found in non-human species. There are two types of Attribute: General Attributes 
are exclusively physical or sensory attributes that can be found in Cosmic species, while esoteric Attributes are extraordinary 
abilities and aspects found in beings from the higher echelons of existence. Humans have no innate Attributes and are only able 
to purchase these if they acquire the halfblood or Voidmarked background.">Attributes:</label>
        <textarea class="character-sheet-textarea" id="attributes" name="attributes"></textarea>

        <label for="backgrounds" title="People are influenced by their past. To illustrate this in the game, players can choose backgrounds for their characters.
Each background grants in-game benefits and acts as the starting point for a good back-story.">Backgrounds:</label>
        <textarea class="character-sheet-textarea" id="backgrounds" name="backgrounds"></textarea>

        <label for="talents" title="">Talents:</label>
        <textarea class="character-sheet-textarea" id="talents" name="talents"></textarea>

        <label for="flaws" title="">Flaws:</label>
        <textarea class="character-sheet-textarea" id="flaws" name="flaws"></textarea>

        <fieldset>
            <legend>Regular Skills</legend>
            <table id="skills-table" class="skills-table">
                <thead>
                    <tr>
                        <th class="skillname-column">Skill Name</th>
                        <th class="rank-column">Rank</th>
                        <th class="keytrait-column">Key Trait</th>
                        <th class="modifier-column">Total Modifier</th>
                        <th class="modifier-column">Rank Modifier</th>
                        <th class="modifier-column">Trait Modifier</th>
                        <th class="modifier-column">Misc Modifier</th>
                        <th class="specialization-column">Specialization</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Repeat this row for each skill -->
                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]"
                                value="Acrobatics" readonly></td>
                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>
                        <td>
                            <select class="trait-dropdown skills-input" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>


                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]" value="Anatomy"
                                readonly></td>
                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>
                        <td>
                            <select class="trait-dropdown skills-input" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]"
                                value="Animal Handling" readonly></td>
                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>
                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>


                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]" value="Athletics"
                                readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]" value="Commerce"
                                readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]"
                                value="Cryptography" readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]" value="Enquiry"
                                readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]"
                                value="Expression" readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]" value="Herbalism"
                                readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]"
                                value="Intimidation" readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]" value="Intrigue"
                                readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]" value="Languages"
                                readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]" value="Larceny"
                                readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]"
                                value="Lore, Common" readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]"
                                value="Lore, Occult" readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]"
                                value="Lore Scholastic" readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]"
                                value="Navigation" readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]"
                                value="Observation" readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]"
                                value="Performance" readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]" value="Rituals"
                                readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]" value="Socialize"
                                readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]" value="Stealth"
                                readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]"
                                value="Streetwise" readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]"
                                value="Subterfuge" readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]" value="Survival"
                                readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>

                    <tr>
                        <td><input class="skills-input skillname-input" type="text" name="skillname[]"
                                value="Trade Skills" readonly></td>

                        <td>
                            <div class="rank-container">
                                <button type="button" class="rank-minus" onclick="adjustRank(this, -1)">-</button>
                                <input class="rank-input" type="number" name="rank[]" value="-1" readonly>
                                <button type="button" class="rank-plus" onclick="adjustRank(this, 1)">+</button>
                            </div>
                        </td>

                        <td>
                            <select class="trait-dropdown" name="keytrait[]">
                                <option value="Agility">Agility</option>
                                <option value="Awareness">Awareness</option>
                                <option value="Stamina">Stamina</option>
                                <option value="Strength">Strength</option>
                                <option value="Intellect">Intellect</option>
                                <option value="Persuasion">Persuasion</option>
                                <option value="Presence">Presence</option>
                                <option value="Willpower">Willpower</option>
                            </select>
                        </td>
                        <td><input class="skills-input modifier-input totalmodifier" type="number"
                                name="totalmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input rankmodifier-input" type="number"
                                name="rankmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input traitmodifier-input" type="number"
                                name="traitmodifier[]" value="0" readonly></td>
                        <td><input class="skills-input modifier-input miscmodifier-input" type="number"
                                name="miscmodifier[]" value="0"></td>
                        <td><input class="skills-input specialization-input" type="text" name="specialization[]"></td>
                    </tr>
                    <!-- Repeat for each skill -->
                </tbody>
            </table>
        </fieldset>



        <button id="openDiceModal">Roll Dice</button>

        <div id="modalOverlay"></div>
        <div id="diceModal">
            <h2>Dice Roller</h2>
            <label for="modifier">Modifier:</label>
            <input type="number" id="modifier" placeholder="Enter modifier" />
            <div>
                <button class="diceButton" data-die="4">1d4</button>
                <button class="diceButton" data-die="6">1d6</button>
                <button class="diceButton" data-die="8">1d8</button>
                <button class="diceButton" data-die="10">1d10</button>
                <button class="diceButton" data-die="12">1d12</button>
                <button class="diceButton" data-die="20">1d20</button>
            </div>
            <div id="result"></div>
            <button id="closeModal">Close</button>
        </div>

        <script>
            // Modal handlers
            const modal = document.getElementById('diceModal');
            const overlay = document.getElementById('modalOverlay');
            const openModal = document.getElementById('openDiceModal');
            const closeModal = document.getElementById('closeModal');

            openModal.addEventListener('click', () => {
                modal.style.display = 'block';
                overlay.style.display = 'block';
            });

            closeModal.addEventListener('click', () => {
                modal.style.display = 'none';
                overlay.style.display = 'none';
            });

            // Dice button handlers
            document.querySelectorAll('.diceButton').forEach(button => {
                button.addEventListener('click', async () => {
                    const dieType = button.dataset.die;
                    const modifier = document.getElementById('modifier').value || 0;

                    // Send request to PHP backend
                    const response = await fetch('dice_roller.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ dieType: parseInt(dieType), modifier: parseInt(modifier) })
                    });
                    const result = await response.json();

                    // Display the result
                    document.getElementById('result').innerHTML = `
                    Rolled: ${result.roll} <br>
                    Modifier: +${result.modifier} <br>
                    Total: ${result.total}
                `;
                });
            });
        </script>





        <!-- TODO: add weapons section -->

        <!-- Submit Button -->
        <input type="hidden" name="sheetid" id="sheetid" value="<?php echo htmlspecialchars($_GET['sheetid']); ?>">
        <input type="submit" value="Save Character Sheet" id="save-button">
        </form>
    </div>
</body>

</html>