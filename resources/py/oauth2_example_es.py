import os
from flask import Flask, redirect, request, url_for, session, render_template_string
from requests_oauthlib import OAuth2Session

# Reemplaza estos valores con los detalles de tu proveedor OAuth2
client_id = '4e8764057ab419a88324fbdcbdbaeadda2cef2a8fa8ad9caf73f3d05486e6f4f'
client_secret = 'dd4fa6e9e45857d1ff57db8580bacdc8f6128561a4fbbc3dee47f15e67bbb8f5'
authorization_base_url = 'https://app.fatiguescience.com/oauth/authorize'
token_url = 'https://app.fatiguescience.com/oauth/token'
redirect_uri = 'https://3303-200-94-63-194.ngrok-free.app/callback'  # Esto debe coincidir con tu URL de ngrok 

app = Flask(__name__)
os.environ['OAUTHLIB_INSECURE_TRANSPORT'] = '1'  # Solo para propósitos de desarrollo

@app.route('/')
def home():
    """Paso 1: Autorización del usuario.
    Redirige al usuario/propietario del recurso al proveedor OAuth usando una URL con algunos parámetros clave de OAuth.
    """
    oauth = OAuth2Session(client_id, redirect_uri=redirect_uri)
    authorization_url, state = oauth.authorization_url(authorization_base_url)

    # El estado se usa para prevenir CSRF, guárdalo para más tarde.
    session['oauth_state'] = state
    return redirect(authorization_url)

@app.route('/callback')
def callback():
    """Paso 2: Obtener un token de acceso.
    El usuario ha sido redirigido de vuelta desde el proveedor a tu URL de callback registrada.
    Con esta redirección viene un código de autorización incluido en la URL de redirección. Lo usaremos para obtener un token de acceso.
    """
    oauth = OAuth2Session(client_id, redirect_uri=redirect_uri, state=request.args.get('state'))
    token = oauth.fetch_token(token_url, client_secret=client_secret, authorization_response=request.url)

    # Guarda el token para usarlo más tarde
    session['oauth_token'] = token

    # Muestra un mensaje indicando que la autenticación está completa y muestra el token
    message = "Autenticación completa. El token se ha guardado para la sesión actual del servidor."
    return render_template_string('''
        <h1>{{ message }}</h1>
        <button onclick="document.getElementById('token').style.display='block'">Mostrar Token</button>
        <button onclick="document.getElementById('token').style.display='none'">Ocultar Token</button>
        <div id="token" style="display:none;">
            <p>{{ token }}</p>
        </div>
    ''', message=message, token=token)

if __name__ == '__main__':
    app.secret_key = 'clave_secreta_aleatoria'
    app.run(debug=True, port=5002)