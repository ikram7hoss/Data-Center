@extends('layouts.admin')

@section('content')
    <h1 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 2rem;">Mon Profil</h1>

    <div class="card" style="max-width: 800px; margin: 0 auto; backdrop-filter: blur(10px);">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="flex" style="gap: 3rem; flex-wrap: wrap;">
                <!-- Avatar Section -->
                <div style="flex: 0 0 200px; text-align: center;">
                    <div style="position: relative; width: 150px; height: 150px; margin: 0 auto 1.5rem auto;">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}?v={{ time() }}" alt="Avatar" 
                                 style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 4px solid var(--accent); box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=150" 
                                 alt="Avatar" 
                                 style="width: 100%; height: 100%; border-radius: 50%; border: 4px solid var(--accent); box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                        @endif
                        
                        <label for="avatar" style="position: absolute; bottom: 5px; right: 5px; background: var(--accent); color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.3); transition: transform 0.2s;">
                            <i class="fas fa-camera"></i>
                            <input type="file" name="avatar" id="avatar" style="display: none;" accept="image/*" onchange="previewImage(this)">
                        </label>
                    </div>
                </div>

                <!-- Form Section -->
                <div style="flex: 1; min-width: 300px;">
                    <div style="margin-bottom: 1.5rem;">
                        <label class="block text-sm font-medium mb-1 text-secondary">Nom Complet</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="input-field @error('name') border-red-500 @enderror" required>
                        @error('name')
                            <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label class="block text-sm font-medium mb-1 text-secondary">Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="input-field @error('email') border-red-500 @enderror" required>
                        @error('email')
                            <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr style="border: 0; border-top: 1px solid var(--border); margin: 2rem 0;">

                    <h3 style="margin-bottom: 1.5rem; color: var(--text-primary); font-size: 1.1rem;">Changer le mot de passe</h3>

                    <div style="margin-bottom: 1.5rem;">
                        <label class="block text-sm font-medium mb-1 text-secondary">Nouveau mot de passe</label>
                        <input type="password" name="password" class="input-field @error('password') border-red-500 @enderror" placeholder="Laisser vide pour ne pas changer">
                        @error('password')
                            <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label class="block text-sm font-medium mb-1 text-secondary">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" class="input-field" placeholder="Confirmer le nouveau mot de passe">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary" style="padding: 0.8rem 2.5rem;">
                            <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    // Update only the main displayed image
                    const img = input.closest('div').querySelector('img');
                    img.src = e.target.result;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <style>
        .input-field {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            color: var(--text-primary);
            padding: 0.8rem 1rem;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .text-secondary {
            color: var(--text-secondary);
        }
    </style>
@endsection
