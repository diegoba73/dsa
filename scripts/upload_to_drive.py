from google.oauth2.credentials import Credentials
from google_auth_oauthlib.flow import InstalledAppFlow
from googleapiclient.discovery import build
from googleapiclient.http import MediaFileUpload
import os

SCOPES = ['https://www.googleapis.com/auth/drive.file']

def authenticate_to_drive(credentials_file):
    creds = None
    if os.path.exists('token.json'):
        creds = Credentials.from_authorized_user_file('token.json')
    if not creds or not creds.valid:
        if creds and creds.expired and creds.refresh_token:
            creds.refresh(Request())
        else:
            flow = InstalledAppFlow.from_client_secrets_file(
                credentials_file, SCOPES)
            creds = flow.run_local_server(port=0)
        with open('token.json', 'w') as token:
            token.write(creds.to_json())
    return creds

def upload_to_drive(file_path, credentials_file):
    creds = authenticate_to_drive(credentials_file)
    drive_service = build('drive', 'v3', credentials=creds)

    file_metadata = {
        'name': os.path.basename(file_path),
    }

    media = MediaFileUpload(file_path, resumable=True)

    file = drive_service.files().create(
        body=file_metadata,
        media_body=media,
        fields='id'
    ).execute()

    print('File ID:', file.get('id'))

if __name__ == '__main__':
    credentials_file = '/var/www/dsa/scripts/client_secret_24055006495-dcc0h39c18qevbkorlqmktl9ci26rpbj.apps.googleusercontent.com.json'  # Reemplaza con la ruta a tu archivo de credenciales
    file_to_upload = '/var/www/dsa/backup_db/backup.sql.gz'  # Reemplaza con la ruta a tu archivo de respaldo

    upload_to_drive(file_to_upload, credentials_file)
