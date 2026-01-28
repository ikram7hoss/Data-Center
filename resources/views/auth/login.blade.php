<div style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; padding: 20px;">

    <div style="background: white; width: 100%; max-width: 450px; padding: 40px; border-radius: 20px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid #ffffff;">

        <div style="text-align: center; margin-bottom: 35px;">
            <h2 style="color: #1e40af; font-size: 28px; font-weight: 800; margin-bottom: 10px;">Bon retour !</h2>
            <p style="color: #64748b; font-size: 14px;">Connectez-vous pour gérer vos ressources.</p>
        </div>

        @if($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border: 1px solid #fecaca;">
                ⚠️ Email ou mot de passe incorrect.
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
            @csrf

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase;">Email</label>
                <input type="email" name="email" placeholder="votre@email.com" required
                    style="width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 15px; transition: 0.3s;"
                    onfocus="this.style.borderColor='#2563eb'; this.style.outline='none';">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase;">Mot de passe</label>
                <input type="password" name="password" placeholder="••••••••" required
                    style="width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 15px; transition: 0.3s;"
                    onfocus="this.style.borderColor='#2563eb'; this.style.outline='none';">
            </div>

            <button type="submit"
                style="margin-top: 10px; background: #2563eb; color: white; padding: 14px; border: none; border-radius: 10px; font-size: 16px; font-weight: 700; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);"
                onmouseover="this.style.background='#1e40af'; this.style.transform='translateY(-1px)';"
                onmouseout="this.style.background='#2563eb'; this.style.transform='translateY(0)';">
                Se connecter
            </button>
        </form>

        <div style="text-align: center; margin-top: 25px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
            <p style="font-size: 14px; color: #64748b;">
                Pas encore de compte ?
                <a href="{{ route('demande.create') }}" style="color: #2563eb; text-decoration: none; font-weight: 600;">Créer une demande</a>
            </p>
        </div>
    </div>
</div>
