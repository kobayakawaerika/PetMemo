PetMemo（ペットの健康・日誌管理アプリ）

ペットの日常の様子や通院記録、メモを簡単に記録・管理できるWebアプリケーションです。

シンプルなUIで「記録のしやすさ」と「情報の一覧性」にこだわって作成しました。

💡 開発背景・解決したい課題

多頭飼いをしている飼い主や、ペットの体調変化を日常的に記録したい飼い主向けに開発しました。

「いつどんなメモを残したか」「誰の記録か」が直感的に切り替えられ、日々の細かな変化を見逃さない仕組みを目指しました。

🛠 使用技術（Tech Stack）

バックエンド: PHP 8.x / Laravel 11.x

フロントエンド: Blade / Tailwind CSS

データベース: MySQL (XAMPP環境)

開発環境: XAMPP (Apache / MySQL)

認証機能: Laravel Breeze

📱 主な機能一覧

1. ユーザー管理機能

新規会員登録 / ログイン / ログアウト

プロフィール編集

2. ペット管理機能

ペットの新規登録 / 編集 / 削除

性別（♂ / ♀ / 不明）に応じたアイコン・記号表示

生年月日に基づく年齢の自動計算表示（◯歳◯ヶ月）

ペット切替タブ（クリックで各ペットのメモに即座にアクセス）

3. メモ（日誌）管理機能

ペットごとのメモ追加・一覧表示

日付・投稿時間の保持

メモの削除機能

4. セキュリティ・認可対策

他人のペットやメモに対する不正な操作（URL直打ち等による参照・更新・削除）の防止

🗄 データベース設計（ER図）

erDiagram
    users ||--o{ pets : "1対多"
    pets ||--o{ memos : "1対多"

    users {
        bigint id PK "ユーザーID"
        string name "ユーザー名"
        string email "メールアドレス"
        string password "パスワード"
    }

    pets {
        bigint id PK "ペットID"
        bigint user_id FK "ユーザーID"
        string name "ペット名"
        string sex "性別"
        date birthday "生年月日"
    }

    memos {
        bigint id PK "メモID"
        bigint pet_id FK "ペットID"
        text content "メモ内容"
        date memo_date "記録日付"
    }


✨ セキュリティ・設計で工夫した点

認可（Authorization）の徹底:
where('user_id', Auth::id()) や whereHas リレーションを活用し、URLのIDを直接変更されても他人のペットやメモの参照・更新・削除ができないように強固な保護を行なっています。

直感的な操作性とUI設計:
Tailwind CSSを用い、どのペットの情報を見ているかが一目でわかる「タブ切り替え」や、レスポンシブに対応したシンプルなレイアウトを構築しました。

モデルでのカプセル化:
sexSymbol() や age() などの表示ロジックをモデル（Pets.php）内にカプセル化し、Blade側での可読性とコードの再利用性を高めています。

🚀 ローカル環境での起動手順 (XAMPP環境)

1. リポジトリのクローン

xampp/htdocs ディレクトリ等で実行します。

git clone https://github.com/kobayakawaerika/PetMemo.git
cd PetMemo


2. パッケージのインストール

composer install
npm install


3. 環境変数の設定 (.env)

cp .env.example .env
php artisan key:generate


※ .env 内のデータベース接続情報を XAMPP の MySQL 設定に合わせて変更してください（例: DB_DATABASE=pet_memo, DB_USERNAME=root, DB_PASSWORD=）。

4. マイグレーションの実行

XAMPPコントロールパネルで Apache と MySQL を起動後、データベースを作成してから実行します。

php artisan migrate


5. アセットビルド & サーバー起動

npm run dev
php artisan serve


ブラウザで http://127.0.0.1:8000 にアクセスします。
