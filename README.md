PetMemo（ペットの健康・日誌管理アプリ）

ペットの日常の様子や通院記録、メモを簡単に記録・管理できるWebアプリケーションです。

シンプルなUIで「記録のしやすさ」と「情報の一覧性」にこだわって作成しました。

💡 開発背景・解決したい課題

多頭飼いをしている飼い主や、ペットの体調変化を日常的に記録したい飼い主向けに開発しました。

「いつどんなメモを残したか」「誰の記録か」が直感的に切り替えられ、日々の細かな変化を見逃さない仕組みを目指しました。

🛠 使用技術（Tech Stack）

バックエンド: PHP 8.x / Laravel 11.x

フロントエンド: Blade / Tailwind CSS

データベース: MySQL 8.0

環境構築: Docker / Laravel Sail

認証機能: Laravel Breeze

📱 主な機能一覧

ユーザー管理

新規会員登録 / ログイン / ログアウト

プロフィール編集

ペット管理機能

ペットの新規登録 / 編集 / 削除

性別（♂ / ♀ / 不明）に応じたアイコン・記号表示

生年月日に基づく年齢の自動計算表示（◯歳◯ヶ月）

ペット切替タブ（クリックで各ペットのメモに即座にアクセス）

メモ（日誌）管理機能

ペットごとのメモ追加・一覧表示

日付・投稿時間の保持

メモの削除機能

セキュリティ対策: 他人のペットやメモに対する不正な操作（直打ちURLアクセス等）の防止

🗄 データベース設計（ER図）

erDiagram
    users ||--o{ pets : "1対多"
    pets ||--o{ memos : "1対多"

    users {
        bigint id PK
        string name
        string email
        string password
    }

    pets {
        bigint id PK
        bigint user_id FK
        string name
        string sex
        date birthday
    }

    memos {
        bigint id PK
        bigint pet_id FK
        text content
        date memo_date
    }


✨ セキュリティ・設計で工夫した点

認可（Authorization）の徹底:

where('user_id', Auth::id()) や whereHas リレーションを活用し、URLのIDを直接変更されても他人のペットやメモの参照・更新・削除ができないように強固な保護を行なっています。

直感的な操作性とUI設計:

Tailwind CSSを用い、どのペットの情報を見ているかが一目でわかる「タブ切り替え」や、レスポンシブに対応したシンプルなレイアウトを構築しました。

モデルでのカプセル化:

sexSymbol() や age() などの表示ロジックをモデル（Pets.php）内にカプセル化し、Blade側での可読性とコードの再利用性を高めています。

🚀 ローカル環境での起動手順

# リポジトリのクローン
git clone https://github.com/kobayakawaerika/PetMemo.git
cd PetMemo

# 環境変数のコピー
cp .env.example .env

# Dockerコンテナの起動 (Laravel Sail)
./vendor/bin/sail up -d

# パッケージインストール & マイグレーション
./vendor/bin/sail composer install
./vendor/bin/sail npm install && ./vendor/bin/sail npm run dev
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
