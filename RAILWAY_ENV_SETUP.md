# Railway Environment Variables Setup

To fix the slow database performance on Railway, you need to update your environment variables in Railway dashboard.

## Current Issue
Using pooler connection which adds 15-20 seconds latency per request.

## Solution Options

### Option 1: Use Direct Connection (Recommended)
In your Railway project settings → Variables, update these values:

```
DB_HOST=aws-0-ap-southeast-1.pooler.supabase.com
DB_PORT=6543
DB_NAME=postgres
DB_USER=postgres.ewhjmxkowruxlvqkzlyv
DB_PASS=etec18104123
```

**Note:** Change port from 5432 to **6543** (direct connection mode)

### Option 2: Use Session Mode Pooler
If Option 1 doesn't work, keep port 5432 but ensure your Supabase pooler is in **Session Mode**:

1. Go to Supabase Dashboard → Project Settings → Database
2. Under "Connection Pooling", set mode to **Session**
3. Use the session pooler connection string

### Option 3: Add IPv4 Compatibility
Railway might be using IPv6 which can cause DNS resolution delays. Update:

```
DB_HOST=aws-0-ap-southeast-1.pooler.supabase.com
```

Try both `aws-0` and `aws-1` prefixes.

## How to Update in Railway

1. Go to https://railway.app
2. Select your project: **crudop-production**
3. Click on your service
4. Go to **Variables** tab
5. Update the DB_* variables
6. Railway will automatically redeploy

## Expected Result
Operations should complete in **under 1 second** instead of 20 seconds.
