# foxgpt
# 概要
 
aafox.netのFoxGPTの仕組みを簡単に説明したリポジトリです．FoxGPTは会話AIとなっており，
ユーザーが好きなワードを入力すると，AIが処理をしてなるべく自然な応答を返してくれる優れモノです．
なお，GitHubでは容量の関係から重みデータを，プログラムの可読性を上げるためにデザインに関する
コードを除外したサンプルコードとなっています．また，本システムはOpenNMTとPHPの利用を前提にしており，
デプロイにあたっては機械学習の実行環境や，PHPサーバーの準備が不可欠となっています．

# ブログへのリンク
会員登録なしで簡単にコミュニケーションがとれます．
* リンク：https://work.aafox.net/fgpt/

# AI部分で使用している技術
 
FoxGPTの重みデータは．Pytorchで実装されているOpenNMT-pyを利用して，Transformerモデルで作成している．
作成に使用するデータは，SNSからクローラーで収集することで作成しました．具体的には，Aさんが「明日京都に旅行行きたい」
と投稿し，Bさんが「お土産よろしく」といった応答のやり取りを収集し，応答の規則性を重みデータとして保存することで，
FoxGPTは作成されています．
  

# Webアプリケーションの実装にあたり使用している技術

FoxGPTでは，入力フォームやFoxGPTからの返信の描画処理をPHPで実装しています．一方，OpenNMTはPythonで作成されています．
そこで，本システムではPHPとPyrhonという2つの異なる言語でプロセス間通信を行うことで，円滑なコミュニケーション
が可能になるように設計しています．プロセス間通信をする場合，ソケット通信，シグナル通信，ネームパイプの3つを検討しましたが，今回の開発では実装の容易性という観点からネームパイプを利用して実装しています．具体的には出力用と入力用の2つのネームパイプを用意し，写真のようにPHPとPythonの各プログラムが記述を随時行うことで，コミュニケーションがとれるようになっています．

![fgpt](https://work.aafox.net/dataimg/fgpt.jpg)
