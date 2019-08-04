# elegant-background-job-php-demo
Demo code for [Elegant background jobs in PHP](https://medium.com/devcupboard/elegant-background-jobs-in-php-c61b91bf582b).

## To run queue worker
(forever running program)
```bash
php bin/queue-worker.php
```

## To invoke sending message
Open another terminal(or tab) and run:
```bash
php bin/send-forgot-password-email.php
```

After that, if you see the output of queue worker, you should see something like this:

```
Processing: App\Job\SendForgotPasswordEmail
Processed: App\Job\SendForgotPasswordEmail
```

That's all. The more messages you add to queue, the more processing will be done by the queue worker. 
