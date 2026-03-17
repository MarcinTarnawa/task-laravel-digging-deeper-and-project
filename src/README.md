# PdfCreator project

Project for creating, editing pdf format and retrive old version

**Main features**:
- Creating PDF invoices
- Viewing and editing invoices
- User login and authorization system
- Sending email

&nbsp;
 
## 💡 Technologies
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white) 8.3.3.v.

&nbsp;
 
## 💿 Installation

Clone this repository, install required technologies, and run the PHP server. You alsoe need 
librarry [DomPDF](https://github.com/barryvdh/laravel-dompdf). They are necessary to support the project.
run this two commands :
```
composer require barryvdh/laravel-dompdf 

composer require moneyphp/money
```
&nbsp;
 
## 🤔 Solutions provided in the project

- the project creates relationships needed to support databases:
```
    public function customerData()
    {
        return $this->hasMany(CustomerData::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
```
 &nbsp;

- methods in the controller with descriptions that retrieve data from databases:
```
    public function history($uuid)
    {
        // Pobieramy wszystkie wersje danej faktury, od najnowszej do najstarszej
        $history = CustomerData::with('customer')
            ->where('invoice_uuid', $uuid)
            ->orderBy('version', 'desc')
            ->get();

        // Jeśli nic nie znaleziono, rzuć 404
        if ($history->isEmpty()) {
            abort(404);
        }

        return view('pdfCreator.history', compact('history'));
    }
```

&nbsp;

## 💭 Conclusions for future projects

In the future, I would like to add a quick preview of created invoices.

&nbsp;

## 🙋‍♂️ Feel free to contact me

Write something nice! Find me on GitHub: [Marcin Tarnawa](https://github.com/MarcinTarnawa)

&nbsp;

## 👏 Thanks / Special thanks / Credits
Thanks to my [Mentor - devmentor.pl](https://devmentor.pl/) – for providing me with this task and for code review.