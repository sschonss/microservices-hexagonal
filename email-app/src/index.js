require('dotenv').config();
const amqp = require('amqplib');

const RABBITMQ_QUEUE = 'email-queue';

async function connectToRabbitMQ() {
    try {
        console.log('Connecting to RabbitMQ...');
        const connection = await amqp.connect({
            hostname: process.env.RABBITMQ_HOST,
            port: parseInt(process.env.RABBITMQ_PORT, 10),
            username: process.env.RABBITMQ_USER,
            password: process.env.RABBITMQ_PASSWORD
        });
        const channel = await connection.createChannel();
        await channel.assertQueue(RABBITMQ_QUEUE, { durable: true });
        console.log('Connected to RabbitMQ');
        return { connection, channel };
    } catch (error) {
        console.error('Failed to connect to RabbitMQ:', error);
        process.exit(1);
    }
}

async function processEmail(channel, msg) {
    const content = msg.content.toString();
    console.log('Received:', content);

    try {
        console.log('E-mail sent to: ', content);
        channel.ack(msg);

    } catch (error) {
        console.error('Failed to send e-mail:', error);
    }
}

(async () => {
    const { connection, channel } = await connectToRabbitMQ();

    console.log('Waiting for messages...');
    channel.consume(RABBITMQ_QUEUE, (msg) =>
        processEmail(channel, msg), { noAck: false });

    process.on('SIGINT', () => {
        console.log('Shutting down...');
        channel.close();
        connection.close();
        console.log('Gracefully shut down');
        process.exit(0);
    });
})();