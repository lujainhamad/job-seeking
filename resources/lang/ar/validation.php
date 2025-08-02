<?php

return [
    'required' => ':attribute مطلوب حقل.',
    'min' => ':attribute يجب أن يكون على الأقل :min أحرف.',
    'email' => ':attribute يجب أن يكون عنوان بريد إلكتروني صالح.',
    'greater_than_previous_bid' => 'يجب أن تكون المزايدة أكبر من أعلى مزايدة سابقة لك وهي :max.',

    //General validation error messages
    'attributes' => [
        'quantity' => 'الكمية',
    ],

    'accepted' => '.يجب قبول :attribute',
    'after' => '.يجب أن يكون :attribute تاريخاً بعد :date',
    'after_or_equal' => '.يجب أن يكون :attribute تاريخاً لاحقًا أو مساويًا لـ :date',
    'array' => '.يجب أن يكون :attribute مصفوفة',
    'before' => '.يجب أن يكون :attribute تاريخاً قبل :date',
    'before_or_equal' => '.يجب أن يكون :attribute تاريخاً سابقًا أو مساويًا لـ :date',
    'between' => [
        'numeric' => '.يجب أن تكون قيمة :attribute بين :min و :max',
        'file' => '.يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت',
        'string' => '.يجب أن يكون طول النص :attribute بين :min و :max حروف',
        'array' => '.يجب أن يحتوي :attribute على عناصر بين :min و :max',
    ],
    'boolean' => '.يجب أن تكون قيمة :attribute صحيحة أو خاطئة',
    'confirmed' => '.تأكيد :attribute غير متطابق',
    'date' => '.:attribute ليس تاريخاً صالحاً',
    'date_equals' => '.يجب أن يكون :attribute تاريخاً مساويًا لـ :date',
    'date_format' => '.لا يتطابق :attribute مع الصيغة :format',
    'different' => '.يجب أن يكون :attribute و :other مختلفين',
    'digits' => '.يجب أن يكون :attribute :digits أرقام',
    'digits_between' => '.يجب أن تكون قيمة :attribute بين :min و :max أرقام',
    'distinct' => '.يحتوي :attribute على قيمة مكررة',
    'ends_with' => '.يجب أن ينتهي :attribute بأحد القيم التالية: :values',
    'exists' => '.القيمة المحددة :attribute غير صالحة',
    'file' => '.يجب أن يكون :attribute ملفاً',
    'filled' => '.يجب أن يحتوي :attribute على قيمة',
    'gt' => [
        'numeric' => '.يجب أن تكون قيمة :attribute أكبر من :value',
        'file' => '.يجب أن يكون حجم الملف :attribute أكبر من :value كيلوبايت',
        'string' => '.يجب أن يكون طول النص :attribute أكبر من :value حروف',
        'array' => '.يجب أن يحتوي :attribute على أكثر من :value عنصر',
    ],
    'integer' => '.:attribute يجب أن يكون عدداً صحيحًا',
    'image' => '.:attribute يجب أن يكون صورة',
    'mimes' => '.:attribute يجب أن يكون ملفاً من نوع: :values',
    'max' => [
        'numeric' => '.قيمة :attribute يجب أن تكون أقل من أو تساوي :max',
        'file' => '.حجم ملف :attribute يجب أن يكون أقل من أو يساوي :max كيلوبايت',
        'string' => '.طول النص في :attribute يجب أن يكون أقل من أو يساوي :max حرف',
        'array' => '.محتوى :attribute يجب أن يحتوي على أقل من أو يساوي :max عنصر',
    ],
    'min' => [
        'numeric' => '.قيمة :attribute يجب أن تكون اكثر من أو تساوي :min',
        'file' => '.حجم ملف :attribute يجب أن يكون اكثر من أو يساوي :min كيلوبايت',
        'string' => '.طول النص في :attribute يجب أن يكون اكثر من أو يساوي :min حرف',
        'array' => '.محتوى :attribute يجب أن يحتوي على اكثر من أو يساوي :min عنصر',
    ],
    'string' => '.:attribute يجب أن يكون نصاً',

    'password' => [
        'min' => '.يجب ألا تقل كلمة السر عن :min أحرف',
        'mixed' => '.يجب أن تحتوي كلمة السر على حرف كبير وحرف صغير على الأقل',
        'letters' => '.يجب أن تحتوي كلمة السر على حرف واحد على الأقل',
        'numbers' => '.يجب أن تحتوي كلمة السر على رقم واحد على الأقل',
        'symbols' => '.يجب أن تحتوي كلمة السر على رمز واحد على الأقل',
        'uncompromised' => '.كلمة السر ظهرت في تسريب بيانات. يرجى اختيار كلمة سر مختلفة',
    ],

    //Custom validation error
    'custom' => [
        'name.required' => '.حقل الاسم مطلوب',
        'name.array' => '.يجب أن يكون الاسم مصفوفة',
        'name.en.required' => '.حقل الاسم الإنجليزي مطلوب',
        'name.en.string' => '.يجب أن يكون الاسم الإنجليزي نصاً',
        'name.en.unique' => '.الاسم الإنجليزي مأخوذ بالفعل',
        'name.unique' => '.الاسم مأخوذ بالفعل',
        'name.ar.required' => '.حقل الاسم العربي مطلوب',
        'name.ar.string' => '.يجب أن يكون الاسم العربي نصاً',
        'name.ar.unique' => '.الاسم العربي مأخوذ بالفعل',
        'name.en.max' => '.يجب ألا يزيد الاسم الإنجليزي عن :max حرفاً',
        'name.ar.max' => '.يجب ألا يزيد الاسم العربي عن :max حرفاً',
        'quantity' => [
            'parent_quantity_exceeded' => 'يجب ألا تتجاوز :attribute الكمية الأساسية وهي :parent_quantity.',
        ],

        // Custom messages for show_name
        'show_name.required' => '.حقل الاسم مطلوب',
        'show_name.array' => '.يجب أن يكون الاسم مصفوفة',
        'show_name.en.required' => '.حقل الاسم الإنجليزي مطلوب',
        'show_name.en.string' => '.يجب أن يكون الاسم الإنجليزي نصاً',
        'show_name.en.unique' => '.الاسم الإنجليزي مأخوذ بالفعل',
        'show_name.en.max' => '.يجب ألا يزيد الاسم الإنجليزي عن :max حرفاً',
        'show_name.ar.required' => '.حقل الاسم العربي مطلوب',
        'show_name.ar.string' => '.يجب أن يكون الاسم العربي نصاً',
        'show_name.ar.unique' => '.الاسم العربي مأخوذ بالفعل',
        'show_name.ar.max' => '.يجب ألا يزيد الاسم العربي عن :max حرفاً',


        'username.required' => '.حقل اسم المستخدم مطلوب',
        'username.string' => '.يجب أن يكون اسم المستخدم نصاً',
        'username.max' => '.يجب ألا يزيد اسم المستخدم عن :max حرفاً',
        'username.unique' => '.اسم المستخدم مأخوذ بالفعل',

        'email.required' => '.حقل البريد الإلكتروني مطلوب',
        'email.email' => '.يجب أن يكون البريد الإلكتروني عنوان بريد إلكتروني صالح',
        'email.unique' => '.البريد الإلكتروني مأخوذ بالفعل',
        'email.max' => '.يجب ألا يزيد البريد الإلكتروني عن :max حرفاً',
        'email.exists' => 'البريد الإلكتروني هذا غير مسجل لدينا',
        'phone.required' => '.حقل الهاتف مطلوب',
        'phone.regex' => '.تنسيق الهاتف غير صالح',
        'phone.unique' => '.رقم الهاتف مأخوذ بالفعل',
        'phone.max' => '.يجب ألا يزيد الهاتف عن :max حرفاً',
        'phone.exists' => '.رقم الهاتف هذا غير مسجل لدينا',

        'ext_number.unique' => '.رقم التحويلة مأخوذ بالفعل',

        'password.required' => '.حقل كلمة المرور مطلوب',
        'password.string' => '.يجب أن تكون كلمة المرور نصاً',
        'password.min' => '.يجب ألا تقل كلمة السر عن :min أحرف',
        'password.confirmed' => '.تأكيد كلمة المرور غير متطابق',

    ],
];
