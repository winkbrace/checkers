/**
 * This object is responsible for drawing the pieces.
 */
window.pieces = {
    ctx: document.querySelector('canvas#pieces').getContext('2d'),
    white: new Image(),
    black: new Image(),
    loaded: 0,

    init: function() {
        // load the images
        this.white.src = '/img/white.png';
        this.black.src = '/img/black.png';
    },

    draw: function(ctx, img, x, y) {
        ctx.drawImage(img, x, y);
    },

    move: function(start, target) {
        board.grid[start.row][start.col].player = null;
        board.grid[target.row][target.col].player = start.player;
        this.redraw(board.grid);
    },

    remove: function(square) {
        board.grid[square.row][square.col].player = null;
        this.redraw(board.grid);
    },

    undo: function(square) {
        board.grid[square.row][square.col].player = square.player;
        this.redraw(board.grid);
    },

    redraw: function(grid) {
        // clear the pieces layer
        this.ctx.clearRect(0, 0, 800, 800);
        let x, y, img;

        // draw the pieces on the board
        for (let r = 0; r < 10; r++) {
            for (let c = 0; c < 10; c++) {
                if ( ! grid[r][c].player) {
                    continue;
                }

                x = 4.5 + (board.squareWidth * c);
                y = 4.5 + (board.squareHeight * r);
                img = grid[r][c].player === 'black' ? this.black : this.white;
                this.draw(this.ctx, img, x, y);
            }
        }

    }
};

window.pieces.init();
