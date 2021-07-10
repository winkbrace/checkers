/**
 * This object is responsible for drawing the board and the pieces on the board.
 */
window.board = {
    ctx: document.querySelector('canvas#board').getContext('2d'),
    grid: [],
    squareWidth: 80,
    squareHeight: 80,

    init: function() {
        // setup the board. [0,0] is top left, so the opponent's side. User plays white.
        let player = null;
        for (let r = 0; r < 10; r++) {
            this.grid[r] = [];
            for (let c = 0; c < 10; c++) {

                player = null;
                if (this.isDarkSquare(r, c) && r <= 3) {
                    player = 'black';
                }
                if (this.isDarkSquare(r, c) && r >= 6) {
                    player = 'white';
                }

                this.grid[r][c] = {'row': r, 'col': c, 'player': player};
            }
        }

        this.draw(this.randomColor());
    },

    draw: function(color) {
        this.ctx.lineWidth   = 1;
        this.ctx.strokeStyle = "black";
        let x, y;

        // draw the squares on the board
        for (let r = 0; r < 10; r++) {
            for (let c = 0; c < 10; c++) {
                x = 0.5 + (this.squareWidth * c);
                y = 0.5 + (this.squareHeight * r);

                // draw border
                this.ctx.strokeRect(x, y, this.squareWidth, this.squareHeight);

                // color square
                const squareColor = this.isDarkSquare(r, c) ? color : 'white';
                this.drawSquare(x, y, squareColor);
            }
        }

        // make outer border white
        this.ctx.strokeStyle = "white";
        this.ctx.strokeRect(0.5, 0.5, 10 * this.squareWidth, 10 * this.squareHeight);

        // assign same color to color picker
        document.getElementById('boardColor').value = color;

        // redraw the pieces
        window.pieces.redraw(this.grid);
    },

    /**
     * Draw the squares with a subtle shadow at the edge
     */
    drawSquare: function(x, y, color) {
        // horizontal gradient
        let gradient = this.ctx.createLinearGradient(x-40, y, x + this.squareWidth + 40, y);
        gradient.addColorStop(0, 'black');
        gradient.addColorStop(0.25, color);
        gradient.addColorStop(0.75, color);
        gradient.addColorStop(1, 'black');
        this.ctx.fillStyle = gradient;
        this.ctx.fillRect(x, y, this.squareWidth, this.squareHeight);

        // vertical gradient
        gradient = this.ctx.createLinearGradient(x, y-40, x, y + this.squareHeight + 40);
        gradient.addColorStop(0, 'black');
        gradient.addColorStop(0.25, 'transparent');
        gradient.addColorStop(0.75, 'transparent');
        gradient.addColorStop(1, 'black');
        this.ctx.fillStyle = gradient;
        this.ctx.fillRect(x, y, this.squareWidth, this.squareHeight);
    },

    isDarkSquare: function(r, c) {
        return (r + c) % 2 === 1;
    },

    randomColor: function() {
        return '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0');
    },

    getSquare: function(x, y) {
        const row = Math.floor(y / this.squareHeight);
        const col = Math.floor(x / this.squareWidth);

        if (row in this.grid && col in this.grid[row]) {
            return this.grid[row][col];
        } else {
            return null;
        }
    },

    remove: function(square) {
        this.grid[square.row][square.col].player = null;
    },
};

window.board.init();

// Change board color by color picker
document.getElementById('boardColor').addEventListener('input', (e) => board.draw(e.target.value));
