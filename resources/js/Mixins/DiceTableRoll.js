export const DiceTableRoll = {
    methods: {
        rollTable(table) {
            let message = table.name + ': [';

            let roll_result = dice.roll(table.dice_size);
            message += roll_result + '] = ';
            for(let i=0; i<table.rows.length;i++) {
                if(roll_result == table.rows[i].range[0] || (table.rows[i].range.length == 2 && roll_result >= table.rows[i].range[0] && roll_result <= table.rows[i].range[1])) {
                    message += table.rows[i].result;
                    break;
                }
            }
            this.flash(message, 'primary');
        }
    }
}
