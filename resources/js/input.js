const pieces = window.pieces;

window.input = {
    canvas: document.getElementById("dragging"),
    ctx: document.getElementById("dragging").getContext("2d"),
    playerColor: 'white',
    draggingPiece: null,
    startSquare: null,

    init: function () {
        this.registerPickUpListener();
        this.registerDraggingListener();
        this.registerPlaceDownListener();
    },

    registerPickUpListener: function() {
        // start dragging a piece on mousedown
        this.canvas.addEventListener('mousedown', e => {
            this.startSquare = board.getSquare(e.offsetX, e.offsetY);

            this.draggingPiece = null;
            if (this.startSquare && this.startSquare.player === this.playerColor) {
                this.draggingPiece = this.startSquare.player;
                pieces.hide(this.startSquare);
            }
        });
    },

    registerDraggingListener: function() {
        // draw the dragged piece at the mouse location
        this.canvas.addEventListener('mousemove', e => {
            if ( ! this.draggingPiece) {
                return;
            }

            const x   = e.offsetX - (board.squareWidth / 2);
            const y   = e.offsetY - (board.squareHeight / 2);
            const img = this.draggingPiece === 'white' ? pieces.white : pieces.black;
            this.clearCanvas();
            pieces.draw(this.ctx, img, x, y);
        });
    },

    registerPlaceDownListener: function() {
        // place the piece on mouseup
        window.addEventListener('mouseup', e => {
            if ( ! this.draggingPiece) {
                return;
            }

            const startSquare = input.startSquare;
            const targetSquare = board.getSquare(e.offsetX, e.offsetY);
            if (targetSquare !== null) {
                (async () => {
                    const config = {
                        'method': 'POST',
                        'body': JSON.stringify({grid: board.grid, start: startSquare, target: targetSquare})
                    };
                    await fetch('api/move', config)
                        .then(response => response.json())
                        .then(response => {
                            // console.log(response);
                            if (response.error) {
                                pieces.redraw();
                                throw new Error(response.error);
                            }
                            // our move was valid, so make it. Also remove the captured stone if we captured.
                            board.grid[startSquare.row][startSquare.col].player = null;
                            board.grid[targetSquare.row][targetSquare.col].player = 'white';
                            if (response.move.capture) {
                                board.remove(response.move.capture);
                            }
                            // then make opponents turn
                            pieces.move(response.ai.start, response.ai.target);
                            if (response.ai.capture) {
                                board.remove(response.ai.capture);
                            }
                            pieces.redraw();
                        })
                        .catch(error => {
                            pieces.redraw()
                        })
                })();
            }

            this.draggingPiece = null;
            this.startSquare   = null;
            this.clearCanvas();
        });
    },

    clearCanvas: function() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
    },
};

window.input.init();
