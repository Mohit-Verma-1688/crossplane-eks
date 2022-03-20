# crossplane-eks
 ssh-keygen -t ed25519 -a 100
argocd repo add git@github.com:Mohit-Verma-1688/crossplane-eks.git --name=repo-crossplane --insecure-ignore-host-key --ssh-private-key-path ./id_personal

# below has been done to change the argoCd password

PASS=$(kubectl -n argocd get secret argocd-initial-admin-secret --template={{.data.password}} | base64 -d; echo)
echo $(< /dev/urandom tr -dc _A-Z-a-z-0–9 | head -c${1:-32}; echo) > .secret
NEWPASS=$(cat .secret)
argocd login localhost:8080 --insecure --username admin --password $PASS
argocd account update-password --current-password $PASS --new-password $NEWPASS
kubectl -n argocd delete secret argocd-initial-admin-secret

# login to ECR in AWS
aws ecr-public get-login-password --region us-east-1 | docker login --username AWS --password-stdin public.ecr.aws/e9p0j2k2

# below has been done to remove login error
curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
unzip awscliv2.zip
sudo ./aws/instal

kubectl crossplane push configuration public.ecr.aws/e9p0j2k2/crossplane-eks:v1

# kubeseal realted work to be done

sudo openssl req -x509 -nodes -newkey rsa:4096 -keyout "$PRIVATEKEY" -out "$PUBLICKEY" -subj "/CN=sealed-secret/O=sealed-secret"

# Try removing or commenting RANDFILE = $ENV::HOME/.rnd line in /etc/ssl/openssl.cnf

kubectl -n "$NAMESPACE" create secret tls "$SECRETNAME" --cert="$PUBLICKEY" --key="$PRIVATEKEY"
kubectl -n "$NAMESPACE" label secret "$SECRETNAME" sealedsecrets.bitnami.com/sealed-secrets-key=active

# this is to get the base64 encoded aws secret

 BASE64ENCODED_AWS_ACCOUNT_CREDS=$(echo -e "[default]\naws_access_key_id = $(aws configure get aws_access_key_id )\naws_secret_access_key = $(aws configure get aws_secret_access_key )" | base64  | tr -d "\n")

#this is to seal the secret using bitnami kubeseal

kubeseal --cert=$PUBLICKEY --format=yaml < aws-credentials-unsealed.yaml > aws-credentials-sealed.yaml

#getting the secret to connect to cluster
#
 kubectl --namespace crossplane-system \
    get secret team-a-eks-cluster \
    --output jsonpath="{.data.kubeconfig}" \
    | base64 -d >kubeconfig.yaml

export KUBECONFIG=$PWD/kubeconfig.yaml


# Registering the cluster

argocd cluster add my-cluster-alias

#If you are not sure of the name of your cluster alias, you can list them with this command, or use the full cluster name:

kubectl config get-contexts
