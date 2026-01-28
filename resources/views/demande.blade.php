<div style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px;">

    <div style="background: white; width: 100%; max-width: 500px; padding: 40px; border-radius: 20px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); border: 1px solid #ffffff;">

        <h2 style="text-align: center; color: #1e40af; font-size: 28px; font-weight: 800; margin-bottom: 10px; letter-spacing: -0.5px;">
            Demande d'Ouverture de Compte
        </h2>
        <p style="text-align: center; color: #64748b; font-size: 14px; margin-bottom: 30px;">
            Remplissez les informations ci-dessous pour accéder au DataCenter.
        </p>

        <form action="{{ route('compte.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
            @csrf

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Nom complet</label>
                <input type="text" name="nom" placeholder="Ex: Hiba Ahsaini" required
                    style="width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 15px; transition: border-color 0.3s;"
                    onfocus="this.style.borderColor='#3b82f6'; this.style.outline='none';">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Email académique</label>
                <input type="email" name="email" placeholder="nom@institution.com" required
                    style="width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 15px; transition: border-color 0.3s;"
                    onfocus="this.style.borderColor='#3b82f6'; this.style.outline='none';">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Mot de passe</label>
                <input type="password" name="password" placeholder="••••••••" required
                    style="width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 15px; transition: border-color 0.3s;"
                    onfocus="this.style.borderColor='#3b82f6'; this.style.outline='none';">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Vous êtes :</label>
                <select name="role" style="width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 15px; background-color: white; cursor: pointer;">
                    <option value="Ingénieur">Ingénieur</option>
                    <option value="Étudiant">Étudiant</option>
                    <option value="Administrateur">Administrateur</option>
                </select>
            </div>

            <button type="submit"
                style="margin-top: 10px; background: linear-gradient(to right, #2563eb, #1e40af); color: white; padding: 14px; border: none; border-radius: 10px; font-size: 16px; font-weight: 700; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(37, 99, 235, 0.3)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(37, 99, 235, 0.2)';">
                Envoyer ma demande
            </button>
        </form>

        <div style="text-align: center; margin-top: 25px;">
            <a href="{{ route('espace.invite') }}" style="color: #64748b; text-decoration: none; font-size: 14px; font-weight: 500; transition: color 0.3s;" onmouseover="this.style.color='#1e40af';">
                ← Retour au catalogue
            </a>
        </div>
    </div>
</div>
@if(session('success'))
    <div style="background-color: #dcfce7; color: #166534; padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center; font-weight: bold; border: 1px solid #bbf7d0;">
        ✅ {{ session('success') }}
    </div>
@endif
