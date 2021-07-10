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
        this.redraw();
    },

    // hide piece when we are dragging
    hide: function(square) {
        const x = 4.5 + (board.squareWidth * square.col);
        const y = 4.5 + (board.squareHeight * square.row);
        this.ctx.clearRect(x, y, board.squareWidth, board.squareHeight);
    },

    redraw: function() {
        // clear the pieces layer
        this.ctx.clearRect(0, 0, 800, 800);
        let x, y, img, square;

        // draw the pieces on the board
        for (let r = 0; r < 10; r++) {
            for (let c = 0; c < 10; c++) {
                square = board.grid[r][c];
                if ( ! square.player) {
                    continue;
                }

                x = 4.5 + (board.squareWidth * c);
                y = 4.5 + (board.squareHeight * r);
                img = square.player === 'black' ? this.black : this.white;
                this.draw(this.ctx, img, x, y);
            }
        }

    }
};

window.pieces.init();
