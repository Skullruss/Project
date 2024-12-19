import sys
import json
import random


class DiceRoller:
    def __init__(self, die_type, modifier):
        self.die_type = die_type
        self.modifier = modifier
        self.roll = 0
        self.total = 0

    def roll_die(self):
        """Rolls a single die and calculates the total with the modifier."""
        self.roll = random.randint(1, self.die_type)
        self.total = self.roll + self.modifier
        return {
            "roll": self.roll,
            "modifier": self.modifier,
            "total": self.total
        }


def main():
    try:
        # Read die type and modifier from command line arguments
        die_type = int(sys.argv[1])
        modifier = int(sys.argv[2])

        # Roll the die and return results
        dice_roller = DiceRoller(die_type, modifier)
        result = dice_roller.roll_die()

        # Output results as JSON
        print(json.dumps(result))
    except Exception as e:
        # Log the error
        print(json.dumps({"error": str(e)}))


if __name__ == "__main__":
    main()
