<div style="max-width: 500px; margin: 40px auto; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border: 1px solid #eee;">
    
    <h2 style="margin-top: 0; color: #333; font-size: 22px; margin-bottom: 20px;">Ustawienia Profilu</h2>

    <form action="{{ route('user.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #555;">Nazwa użytkownika</label>
            <input type="text" name="name" value="{{ auth()->user()->name }}" 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 14px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #555;">Kolor Twojej marki</label>
            <div style="display: flex; align-items: center; gap: 15px;">
                <input type="color" name="brand_color" value="{{ auth()->user()->brand_color ?? '#0d6efd' }}" 
                       style="border: none; width: 50px; height: 50px; cursor: pointer; background: none; padding: 0;">
                <span style="font-size: 13px; color: #888;">Ten kolor pojawi się na Twoich fakturach</span>
            </div>
        </div>

        <div style="margin-bottom: 25px; padding: 15px; background: #f9f9f9; border-radius: 8px; border: 1px dashed #ccc;">
            <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #555;">Logo firmy (PNG, JPG)</label>
            
            @if(auth()->user()->logo_path)
                <div style="margin-bottom: 15px; text-align: center; background: white; padding: 10px; border-radius: 6px; border: 1px solid #eee;">
                    <p style="font-size: 12px; color: #999; margin-bottom: 8px;">Aktualne logo:</p>
                    <img src="{{ asset('storage/' . auth()->user()->logo_path) }}" 
                         style="max-width: 100%; height: 60px; object-fit: contain; display: block; margin: 0 auto;">
                </div>
            @endif
            
            <input type="file" name="logo" style="font-size: 13px; color: #666;">
        </div>

        <button type="submit" 
                style="width: 100%; background-color: #0d6efd; color: white; padding: 12px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 16px; transition: background 0.3s;">
            Zapisz zmiany
        </button>
        <a href="/pdf" class="btn btn-link mt-3 text-decoration-none text-muted">Powrót</a>
    </form>
</div>