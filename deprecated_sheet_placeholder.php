<div> <!--TODO: Change this class to be attribute specific-->
            <fieldset>
                <label for="attributeids">Attributes:</label>
                <input type="text" id="attributeids" name="attributeids">
            </fieldset>
        </div>

        <div class="background-section" id="background-sections"></div>
        <button class="add-background-btn" id="add-background-btn" type="button">Add Background</button>

        <!-- Talents and Flaws -->
        <div class="talents-section">
            <fieldset>
                <label for="talentids">Talents:</label>
                <select id="talents" name="talents">
                    <option value="" disabled selected>Select a Talent</option>

                    <optgroup label="Agility">
                        <option value="Ambidexterity">Ambidexterity</option>
                        <option value="Coordination">Coordination</option>
                        <option value="Fast Reflexes">Fast Reflexes</option>
                        <option value="Fleet of Foot">Fleet of Foot</option>
                        <option value="Nimble Fingers">Nimble Fingers</option>
                        <option value="Graceful">Graceful</option>
                        <option value="Limber">Limber</option>
                    </optgroup>

                    <optgroup label="Awareness">
                        <option value="Acute Sense">Acute Sense</option>
                        <option value="Alertness">Alertness</option>
                        <option value="Direction Sense">Direction Sense</option>
                        <option value="Empathy">Empathy</option>
                        <option value="Intrinsic Insight">Intrinsic Insight</option>
                        <option value="Vigilant">Vigilant</option>
                        <option value="Cognisance">Cognisance</option>
                    </optgroup>

                    <optgroup label="Stamina">
                        <option value="High Pain Threshold">High Pain Threshold</option>
                        <option value="Less Sleep">Less Sleep</option>
                        <option value="Quick Healer">Quick Healer</option>
                        <option value="Tolerance">Tolerance</option>
                        <option value="Tough">Tough</option>
                        <option value="Very Fit">Very Fit</option>
                        <option value="Robust">Robust</option>
                    </optgroup>

                    <optgroup label="Strength">
                        <option value="Brawny">Brawny</option>
                        <option value="Explosive Force">Explosive Force</option>
                        <option value="Flexible Power">Flexible Power</option>
                        <option value="Strong Legs">Strong Legs</option>
                        <option value="Unyielding">Unyielding</option>
                        <option value="Vigorous">Vigorous</option>
                        <option value="Strong Grip">Strong Grip</option>
                    </optgroup>

                    <optgroup label="Intellect">
                        <option value="Natural Linguist">Natural Linguist</option>
                        <option value="Creative Thinker">Creative Thinker</option>
                        <option value="Eidetic Memory">Eidetic Memory</option>
                        <option value="Focused">Focused</option>
                        <option value="Quick Learner">Quick Learner</option>
                        <option value="Quick Thinker">Quick Thinker</option>
                    </optgroup>

                    <optgroup label="Persuasion">
                        <option value="Adaptability">Adaptability</option>
                        <option value="Mimic">Mimic</option>
                        <option value="Perfect Liar">Perfect Liar</option>
                        <option value="Specious">Specious</option>
                        <option value="Thespian">Thespian</option>
                        <option value="Veil Communication">Veil Communication</option>
                    </optgroup>

                    <optgroup label="Presence">
                        <option value="Beautiful">Beautiful</option>
                        <option value="Born Performer">Born Performer</option>
                        <option value="Charmer">Charmer</option>
                        <option value="Eloquent">Eloquent</option>
                        <option value="Imposing">Imposing</option>
                        <option value="Inspiring">Inspiring</option>
                    </optgroup>

                    <optgroup label="Willpower">
                        <option value="Determined">Determined</option>
                        <option value="Collected">Collected</option>
                        <option value="Composed">Composed</option>
                        <option value="Fearless">Fearless</option>
                        <option value="Ignore Pain">Ignore Pain</option>
                        <option value="Resolve">Resolve</option>
                    </optgroup>
                </select>


                <label for="flaws">Flaws:</label>
                <select id="talents" name="talents">
                    <option value="placeholder">placeholder</option>
                </select>
            </fieldset>
        </div>

        <script>
            let backgroundCount = 0;
            const backgroundids = [];  // Initialize the backgroundids array

            document.getElementById('add-background-btn').addEventListener('click', function () {
                if (backgroundCount < 99) {
                    addBackgroundSection();
                    backgroundCount++;
                } else {
                    alert("Maximum of 99 backgrounds reached.");
                }
            });

            function addBackgroundSection() {
                const container = document.getElementById('background-sections');

                // Create a wrapper div for the new background section
                const newSection = document.createElement('div');
                newSection.classList.add('background-section');

                // Create the fieldset element
                const fieldset = document.createElement('fieldset');

                // Create the label for the background select
                const labelSelect = document.createElement('label');
                labelSelect.setAttribute('for', `background-select-${backgroundCount}`);
                labelSelect.innerHTML = "Background:";

                // Create the select element for the background dropdown
                const select = document.createElement('select');
                select.setAttribute('id', `background-select-${backgroundCount}`);
                select.setAttribute('name', `background-select-${backgroundCount}`);

                // Create the label for the background description
                const labelDescription = document.createElement('label');
                labelDescription.setAttribute('for', `background-description-${backgroundCount}`);
                labelDescription.innerHTML = "Description:";

                // Create the textarea for the background description
                const textarea = document.createElement('textarea');
                textarea.classList.add('background-description');
                textarea.setAttribute('readonly', true);

                // Append everything to the fieldset
                fieldset.appendChild(labelSelect);
                fieldset.appendChild(select);
                fieldset.appendChild(labelDescription);
                fieldset.appendChild(textarea);

                // Append the fieldset to the new background section
                newSection.appendChild(fieldset);

                // Append the new section to the container
                container.appendChild(newSection);

                // Load backgrounds into the newly created select element and textarea
                loadBackgrounds(select, textarea, backgroundCount);  // Pass the slot index to the function
            }

        </script>