@component('mail::message')
# Donation Penalty Notice

Dear {{ $penalty->user->name }},

Our records show that you have not made a donation in the last **3 days**.  
A penalty of **₱{{ number_format($penalty->amount, 2) }}** has been applied to your account.

**Reason:** {{ $penalty->reason }}

Please make your next donation to avoid additional penalties.

Thanks,  
**PundoHub Team**
@endcomponent
