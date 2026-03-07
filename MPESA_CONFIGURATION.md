# M-Pesa Payment Configuration

# Add these to your .env file for M-Pesa integration

# M-Pesa API Credentials (Get from Safaricom Developer Portal)
MPESA_CONSUMER_KEY=your_consumer_key_here
MPESA_CONSUMER_SECRET=your_consumer_secret_here
MPESA_PASSKEY=your_passkey_here

# M-Pesa Business Details
MPESA_SHORTCODE=your_business_shortcode
MPESA_TILL_NUMBER=your_till_number

# Environment (sandbox for testing, production for live)
MPESA_ENVIRONMENT=sandbox

# M-Pesa Callback URL (automatically set to your application)
MPESA_CALLBACK_URL=https://your-domain.com/payment/mpesa/callback

# Instructions:
# 1. Get credentials from Safaricom Developer Portal
# 2. For testing, use sandbox credentials
# 3. For production, use live credentials
# 4. Set MPESA_ENVIRONMENT to 'production' for live payments
# 5. Optional: Set MPESA_TILL_NUMBER for till payments
# 6. If not set, will use STK Push (Buy Goods)
