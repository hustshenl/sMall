#!/bin/bash

# 请将本文件放在项目根目录！！！
# BasePath=$(cd `dirname $0`; pwd)
RootPath=$(cd `dirname $0`; pwd)
Apps=(admin backend main member api)
Environment=
EnvConf=env.conf


while getopts "b:e:" arg
do
    case $arg in
        b)
            Branch=$OPTARG
            ;;
        e)
            Environment=$OPTARG
            ;;
        ?)
            #当有不认识的选项的时候arg为?
            echo "含有非法选项！"
            exit 1
            ;;
     esac
done
if [ "${Branch}" = "" ]
then
    Branch=master
fi
if [ "$Environment" = "" ]
then
    if [ ! -f "${EnvConf}" ]
    then
    read -p "请选择服务器环境【dev | test | prod】:
" env
        Environment=$env
    #else
        else
        Environment=`cat ${EnvConf}`
    fi
fi
echo ${Environment} > ${EnvConf}
if [ "$Environment" = "prod" ]
then
    read -p "确定要部署分支：${Branch} 到${Environment}环境吗？
输入【yes】继续，其他任意字符取消！
" confirm
    if [ "$confirm" != "yes" ]
    then
        echo "取消部署任务"
        exit 1
    fi
    else
    echo "开始部署分支：${Branch} 到${Environment}环境"
fi

cd ${RootPath}

git clean -f -d > /dev/null
git fetch origin
git reset --hard origin/${Branch}


#复制网站配置文件，重启Nginx，显示升级页面
#cp -f ${RootPath}/environments/$Environment/upgrade.conf ${RootPath}/vhost.conf
#sed s/{sinmhRoot}/${RootPath//\//\\/}/g ${RootPath}/environments/$Environment/upgrade.conf > ${RootPath}/vhost.conf

/etc/init.d/nginx reload > /dev/null 2>&1


chmod -R 755 ${RootPath}
chmod -R 777 ${RootPath}/src/resource/web
for app in ${Apps[@]};do
chmod -R 777 ${RootPath}/src/${app}/runtime
chmod -R 777 ${RootPath}/src/${app}/web/assets
done


chown -R www:www ${RootPath}/src
chown -R www:www ${RootPath}/tools

#cp -f ${RootPath}/environments/$Environment/run.conf ${RootPath}/vhost.conf
#sed s/{sinmhRoot}/${RootPath//\//\\/}/g ${RootPath}/environments/$Environment/run.conf > ${RootPath}/nginx.conf
/etc/init.d/nginx reload
echo "部署完成"