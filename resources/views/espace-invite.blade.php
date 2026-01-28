<div style="display: flex; font-family: 'Segoe UI', sans-serif; background-color: #f8fafc; min-height: 100vh;">

    <div style="width: 280px; background: white; padding: 25px; border-right: 1px solid #e2e8f0; height: 100vh; position: sticky; top: 0;">
        <h2 style="color: #1e40af; display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 20px;">🔍</span> Filtres
        </h2>
        <div style="margin-top: 20px;">
            <label style="display: block; font-size: 13px; font-weight: bold; color: #64748b; margin-bottom: 8px;">RECHERCHE</label>
            <input type="text" placeholder="Nom, Série, Rack..." style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
        </div>
        <div style="margin-top: 20px;">
            <label style="display: block; font-size: 13px; font-weight: bold; color: #64748b; margin-bottom: 8px;">ÉTAT ACTUEL</label>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label style="padding: 8px; border: 1px solid #e2e8f0; border-radius: 6px; cursor: pointer; font-size: 14px;">
                    <input type="radio" name="status"> Disponible
                </label>
                <label style="padding: 8px; border: 1px solid #e2e8f0; border-radius: 6px; cursor: pointer; font-size: 14px;">
                    <input type="radio" name="status"> Occupé
                </label>
            </div>
        </div>
    </div>

    <div style="flex: 1; padding: 40px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px;">

            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;">
                <div style="position: relative; background: #f1f5f9; height: 160px; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 50px;">💾</span>
                    <span style="position: absolute; top: 12px; right: 12px; background: #dcfce7; color: #166534; font-size: 11px; font-weight: bold; padding: 4px 10px; border-radius: 20px; border: 1px solid #bbf7d0;">✓ Disponible</span>
                </div>
                <div style="padding: 20px;">
                    <p style="color: #2563eb; font-size: 11px; font-weight: bold; text-transform: uppercase;">Stockage</p>
                    <h3 style="margin: 5px 0 15px 0; color: #1e293b;">SRV-IBM-STORAGE</h3>
                    <div style="font-size: 13px; color: #64748b; line-height: 1.8;">
                        <div>⚡ <b>CPU:</b> 8 | <b>RAM:</b> 32 GB</div>
                        <div>💿 <b>OS:</b> TrueNAS</div>
                        <div>📍 <b>Rack:</b> C1 (Capacité: 10000)</div>
                    </div>
                    <div style="margin-top: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-weight: bold; font-size: 18px;">0.5€<small style="font-weight: normal; color: #94a3b8;">/h</small></span>
                        <a href="{{ route('demande.create') }}" style="background: #2563eb; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 500;">Réserver</a>
                    </div>
                </div>
            </div>

            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; opacity: 0.8;">
                <div style="position: relative; background: #f1f5f9; height: 160px; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 50px;">🖥️</span>
                    <span style="position: absolute; top: 12px; right: 12px; background: #fee2e2; color: #991b1b; font-size: 11px; font-weight: bold; padding: 4px 10px; border-radius: 20px; border: 1px solid #fecaca;">● Indisponible</span>
                </div>
                <div style="padding: 20px;">
                    <p style="color: #64748b; font-size: 11px; font-weight: bold; text-transform: uppercase;">Serveur</p>
                    <h3 style="margin: 5px 0 15px 0; color: #1e293b;">SRV-WINDOWS-SERVER</h3>
                    <div style="font-size: 13px; color: #64748b; line-height: 1.8;">
                        <div>⚡ <b>CPU:</b> 32 | <b>RAM:</b> 128 GB</div>
                        <div>💿 <b>OS:</b> Win Server 2022</div>
                        <div>📍 <b>Rack:</b> B3</div>
                    </div>
                    <div style="margin-top: 20px; text-align: right;">
                        <span style="background: #f1f5f9; color: #94a3b8; padding: 8px 16px; border-radius: 6px; font-size: 14px;">Indisponible</span>
                    </div>
                </div>
            </div>

            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;">
                <div style="position: relative; background: #f1f5f9; height: 160px; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 50px;">🐧</span>
                    <span style="position: absolute; top: 12px; right: 12px; background: #dcfce7; color: #166534; font-size: 11px; font-weight: bold; padding: 4px 10px; border-radius: 20px; border: 1px solid #bbf7d0;">✓ Disponible</span>
                </div>
                <div style="padding: 20px;">
                    <p style="color: #2563eb; font-size: 11px; font-weight: bold; text-transform: uppercase;">Serveur</p>
                    <h3 style="margin: 5px 0 15px 0; color: #1e293b;">SRV-UBUNTU-DATA</h3>
                    <div style="font-size: 13px; color: #64748b; line-height: 1.8;">
                        <div>⚡ <b>CPU:</b> 16 | <b>RAM:</b> 64 GB</div>
                        <div>💿 <b>OS:</b> Ubuntu 22.04</div>
                        <div>📍 <b>Rack:</b> A1 (Capacité: 2000)</div>
                    </div>
                    <div style="margin-top: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-weight: bold; font-size: 18px;">0.5€<small style="font-weight: normal; color: #94a3b8;">/h</small></span>
                        <a href="{{ route('demande.create') }}" style="background: #2563eb; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 500;">Réserver</a>
                    </div>
                </div>
            </div>

            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;">
                <div style="position: relative; background: #f1f5f9; height: 160px; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 50px;">🌐</span>
                    <span style="position: absolute; top: 12px; right: 12px; background: #dcfce7; color: #166534; font-size: 11px; font-weight: bold; padding: 4px 10px; border-radius: 20px; border: 1px solid #bbf7d0;">✓ Disponible</span>
                </div>
                <div style="padding: 20px;">
                    <p style="color: #2563eb; font-size: 11px; font-weight: bold; text-transform: uppercase;">Réseau</p>
                    <h3 style="margin: 5px 0 15px 0; color: #1e293b;">SRV-CISCO-PRO</h3>
                    <div style="font-size: 13px; color: #64748b; line-height: 1.8;">
                        <div>⚡ <b>CPU:</b> 64 | <b>RAM:</b> 256 GB</div>
                        <div>💿 <b>OS:</b> RedHat Enterprise</div>
                        <div>📍 <b>Rack:</b> D5 (Capacité: 8000)</div>
                    </div>
                    <div style="margin-top: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-weight: bold; font-size: 18px;">0.8€<small style="font-weight: normal; color: #94a3b8;">/h</small></span>
                        <a href="{{ route('demande.create') }}" style="background: #2563eb; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 500;">Réserver</a>
                    </div>
                </div>
            </div>

  <div style="margin-top: 50px; display: flex; flex-direction: column; align-items: center; gap: 20px;">

    <div style="display: flex; gap: 20px; width: 90%; justify-content: center;">

        <a href="{{ route('login') }}" style="flex: 1; max-width: 300px; text-align: center; background: white; color: #2563eb; padding: 18px; text-decoration: none; border-radius: 12px; font-size: 18px; font-weight: bold; border: 2px solid #2563eb; transition: all 0.3s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='white';">
            Se connecter
        </a>

        <a href="{{ route('demande.create') }}" style="flex: 1; max-width: 300px; text-align: center; background: #2563eb; color: white; padding: 18px; text-decoration: none; border-radius: 12px; font-size: 18px; font-weight: bold; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
            Créer un compte
        </a>

    </div>

    <p style="color: #64748b; font-size: 14px;">Accédez aux ressources du DataCenter en quelques clics.</p>
</div>

    </div> </div>
