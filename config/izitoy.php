<?php
return ['email'=>env('CONTACT_EMAIL',''), 'phone'=>(env('CONTACT_PHONE') ?: '600 042 660'), 'company'=>env('COMPANY_NAME',''), 'address'=>env('COMPANY_ADDRESS',''), 'nip'=>env('COMPANY_NIP','')];
