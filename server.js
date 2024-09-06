const WebSocket = require('ws');

const wss = new WebSocket.Server({ port: 8080 });

wss.on('connection', (ws) => {
    console.log('Client connected');

    // Send a message to the client
    ws.send('Hello from the server!');

    // Handle incoming messages from the client
    ws.on('message', (message) => {
        console.log(`Received: ${message}`);
    });

    // Handle client disconnects
    ws.on('close', () => {
        console.log('Client disconnected');
    });
});

console.log('WebSocket server is running on ws://localhost:8080');
